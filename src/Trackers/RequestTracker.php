<?php

namespace Cboxdk\StatamicOverseer\Trackers;

use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Support\Facades\Session;
use Statamic\Support\Arr;
use Statamic\Support\Str;

class RequestTracker extends Tracker
{
    public function register($app)
    {
        $app['events']->listen(RequestHandled::class, [$this, 'recordRequest']);
    }

    public function recordRequest(RequestHandled $event)
    {
        if (! Overseer::isTracking() || $this->shouldIgnoreRequest($event)) {
            return;
        }

        rescue(function () use ($event) {
            $request = $event->request;
            $response = $event->response;

            $payload = $request->input();

            if ($request->files->count() > 0) {
                $files = $request->files->all();
                array_walk_recursive($files, function (&$file) {
                    $file = [
                        'name' => $file->getClientOriginalName(),
                        'size' => $file->isFile() ? ($file->getSize() / 1000).'KB' : '0',
                    ];
                });

                $payload = array_replace_recursive($payload, $files);
            }

            $cachedResponse = false;

            if (is_callable([$response, 'wasStaticallyCached'])) {
                try {
                    if ($response->wasStaticallyCached()) {
                        $cachedResponse = true;
                    }
                } catch (\Exception $exception) {

                }
            }

            // Log http request and response data
            $event = new Event('request', [
                'session_id' => Session::id() ?? null,
                'url' => $request->url(),
                'payload' => $this->payload($payload),
                'method' => $request->method(),
                'headers' => $this->headers($request->headers->all()),
                'ip_address' => $request->getClientIp(),
                'ip_addresses' => $request->ips(),
                'response_code' => $response->status(),
                'response_cache_hit' => $cachedResponse,
                'middleware' => array_values(optional($request->route())->gatherMiddleware() ?? []),
                'created_at' => now()->format('Y-m-d\TH:i:s.u'),
                'updated_at' => now()->format('Y-m-d\TH:i:s.u'),
            ]);
            Overseer::trackEvent($event);
        });

    }

    /**
     * Determine if the request should be ignored based on the config patterns.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function shouldIgnoreRequest(RequestHandled $event): bool
    {
        // Ignorér baseret på HTTP-metoder
        $ignoreMethods = $this->options['ignore_http_methods'] ?? [];
        if (in_array(strtolower($event->request->method()), array_map('strtolower', $ignoreMethods))) {
            return true;
        }

        // Ignorér baseret på statuskoder
        $ignoreStatus = $this->options['ignore_status_codes'] ?? [];
        if (in_array($event->response->getStatusCode(), $ignoreStatus)) {
            return true;
        }

        // Ignorér baseret på stier
        $ignorePaths = $this->options['ignore_http_paths'] ?? [];
        foreach ($ignorePaths as $pattern) {
            $pattern = Str::of($pattern)->replaceStart('/', '')->toString();
            if (Str::is($pattern, $event->request->path())) {
                return true;
            }
        }

        // Ignorér baseret på middleware
        $ignoreMiddleware = $this->options['ignore_middlewares'] ?? [];
        $middlewares = array_values(optional($event->request->route())->gatherMiddleware() ?? []);

        // Hvis der ikke er nogen middleware i $middlewares, som ikke er i $ignoreMiddleware
        if (array_intersect($middlewares, $ignoreMiddleware)) {
            return true;
        }

        // Ingen af kriterierne for at ignorere request blev opfyldt
        return false;
    }

    /**
     * Format the given payload.
     *
     * @param  array  $payload
     * @return array
     */
    protected function payload($payload)
    {
        return $this->hideParameters($payload,
            ['password']
        );
    }

    /**
     * Format the given headers.
     *
     * @param  array  $headers
     * @return array
     */
    protected function headers($headers)
    {
        $headers = collect($headers)
            ->map(fn ($header) => implode(', ', $header))
            ->all();

        return $this->hideParameters($headers,
            ['password']
        );
    }

    /**
     * Hide the given parameters.
     *
     * @param  array  $data
     * @param  array  $hidden
     * @return mixed
     */
    protected function hideParameters($data, $hidden)
    {
        foreach ($hidden as $parameter) {
            if (Arr::get($data, $parameter)) {
                Arr::set($data, $parameter, '********');
            }
        }

        return $data;
    }
}
