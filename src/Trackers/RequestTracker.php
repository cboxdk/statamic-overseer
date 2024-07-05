<?php

namespace Cboxdk\StatamicOverseer\Trackers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Session;
use Statamic\Support\Arr;
use Statamic\Support\Str;
use Symfony\Component\HttpFoundation\RedirectResponse;

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
                'response' => $this->response($event->response),
                'response_code' => $response->getStatusCode(),
                'response_cache_hit' => $cachedResponse,
                'middleware' => array_values(optional($request->route())->gatherMiddleware() ?? []),
                'created_at' => now()->format('Y-m-d\TH:i:s.u'),
                'updated_at' => now()->format('Y-m-d\TH:i:s.u'),
            ]);
            Overseer::trackEvent($event);

            // Workaround for missing events
            if ($request->path() === 'cp/users/actions' && $response->status() === 200) {
                $rawPayload = json_decode($request->getContent(), true);
                if ($rawPayload['action'] === 'impersonate') {
                    $userId = $rawPayload['selections'][0] ?? null;
                    Overseer::addMessage(new Audit(
                        message: 'Impersonated User',
                        model_type: 'user',
                        model_id: $userId,
                    ));
                }
            }
            if ($request->path() === 'cp/auth/stop-impersonating') {
                Overseer::addMessage(new Audit(
                    message: 'Stop impersonating User',
                ));
            }

        });

    }

    /**
     * Determine if the request should be ignored based on the config patterns.
     *
     * @param  \Illuminate\Http\Request  $request
     */
    protected function shouldIgnoreRequest(RequestHandled $event): bool
    {
        $ignorePaths = $this->options['ignore_paths'] ?? [];
        foreach ($ignorePaths as $pattern) {
            $pattern = Str::of($pattern)->replaceStart('/', '')->toString();
            if (Str::is($pattern, $event->request->path())) {
                return true;
            }
        }

        $ignoreMiddleware = $this->options['ignore_middlewares'] ?? [];
        $middlewares = array_values(optional($event->request->route())->gatherMiddleware() ?? []);

        if (array_intersect($middlewares, $ignoreMiddleware)) {
            return true;
        }

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
            $this->options['hide_parameters'] ?? []
        );
    }

    /**
     * Format the given response object.
     *
     * @return array|string
     */
    protected function response(\Symfony\Component\HttpFoundation\Response $response)
    {
        $content = $response->getContent();

        if (is_string($content)) {
            if (is_array(json_decode($content, true)) &&
                json_last_error() === JSON_ERROR_NONE) {
                return $this->contentWithinLimits($content)
                    ? $this->hideParameters(json_decode($content, true), $this->options['hide_parameters'] ?? [])
                    : 'Purged By Overseer';
            }

            if (Str::startsWith(strtolower($response->headers->get('Content-Type') ?? ''), 'text/plain')) {
                return $this->contentWithinLimits($content) ? $content : 'Purged By Overseer';
            }
        }

        if ($response instanceof RedirectResponse) {
            return 'Redirected to '.$response->getTargetUrl();
        }

        if ($response instanceof Response && $response->getOriginalContent() instanceof View) {
            return [
                'view' => $response->getOriginalContent()->getPath(),
            ];
        }

        if (is_string($content) && empty($content)) {
            return 'Empty Response';
        }

        return 'HTML Response';
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
            $this->options['hide_headers'] ?? []
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

    /**
     * Determine if the content is within the set limits.
     *
     * @param  string  $content
     * @return bool
     */
    public function contentWithinLimits($content)
    {
        $limit = $this->options['size_limit'] ?? 64;

        return intdiv(mb_strlen($content), 1000) <= $limit;
    }
}
