<?php

namespace Cboxdk\StatamicOverseer;

use Cboxdk\StatamicOverseer\Models\OverseerAudit;
use Cboxdk\StatamicOverseer\Models\OverseerEvent;
use Cboxdk\StatamicOverseer\Models\OverseerExecution;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Statamic\Facades\User;
use Statamic\Support\Str;

class Overseer
{
    public static array $events = [];

    public static array $audits = [];

    public static $user;

    public static $impersonator;

    public static bool $shouldTrack = false;

    public static array $trackers = [];

    public static float $startTime;

    public static array $startCpuUsage;

    public function start($app)
    {
        static::$shouldTrack = true;
        static::$startTime = microtime(true);
        static::$startCpuUsage = getrusage();
    }

    public function enabled(): bool
    {
        return config('statamic.overseer.enabled', false);
    }

    public function isTracking(): bool
    {
        return self::$shouldTrack;
    }

    public function serverEnabled(): bool
    {
        return config('statamic.overseer.server.enabled', false);
    }

    public function setUser($user): void
    {
        self::$user = $user;
    }

    public function trackEvent($event): void
    {
        if (! self::$user) {
            try {
                if (Auth::hasResolvedGuards() && Auth::hasUser()) {
                    self::$user = Auth::user();
                    if (self::$user) {
                        // Impersonation
                        if ($impersonation = session()->get('statamic_impersonated_by')) {
                            self::$impersonator = User::find($impersonation);
                        }
                    }
                }
            } catch (\Throwable $e) {
                // Do nothing.
            }
        }

        self::$events[] = $event;
    }

    public function addMessage(Audit $audit): void
    {
        self::$audits[] = $audit;
    }

    public function store(): void
    {
        // Stop tracking at this point
        self::$shouldTrack = false;

        if (count(static::$events) > 0) {

            // performance
            $startTime = defined('LARAVEL_START') ? LARAVEL_START : request()->request->server('REQUEST_TIME_FLOAT') ?? null;
            $duration = $startTime ? floor((microtime(true) - $startTime) * 1000) : null;
            $memory = round(memory_get_peak_usage(true) / 1024 / 1024, 1);

            // Calculate cpu usage
            $endTime = microtime(true);
            $endCpuUsage = getrusage();
            $cpuUsage = $this->calculateCpuUsage(static::$startCpuUsage, $endCpuUsage);

            $elapsedTime = $endTime - static::$startTime;
            $cpuUsagePercentage = (round($cpuUsage['cpu_user_time'] + $cpuUsage['cpu_system_time'], 4) / $elapsedTime) * 100;
            $cpuUsage['cpu_usage_percentage'] = $cpuUsagePercentage;

            // set
            $executionId = Str::orderedUuid()->toString();

            // user
            $user = self::$user;
            $impersonator = self::$impersonator;

            // Persist to local storage
            if (config('statamic.overseer.storage.enabled')) {
                rescue(function () use (&$executionId, &$duration, &$memory, &$cpuUsage, &$user, &$impersonator) {
                    $execution = new OverseerExecution();
                    $execution->id = $executionId;
                    $execution->fill([
                        'user_id' => $user->id ?? null,
                        'impersonator_id' => $impersonator->id ?? null,
                        'host' => gethostname(),
                        'pid' => getmypid(),
                        'duration' => $duration,
                        'memory' => $memory,
                        ...$cpuUsage,
                    ]);
                    $execution->save();

                    /** @var Audit $event */
                    foreach (static::$audits as $event) {
                        $audit = new OverseerAudit();
                        $audit->fill([
                            'execution_id' => $executionId,
                            'user_id' => $user->id ?? null,
                            'impersonator_id' => $impersonator->id ?? null,
                            ...$event->toArray(),
                        ]);
                        $audit->save();
                    }

                    /** @var Event $eventData */
                    foreach (static::$events as $eventData) {
                        $event = new OverseerEvent();
                        $event->fill([
                            'execution_id' => $executionId,
                            'user_id' => $user->id ?? null,
                            'impersonator_id' => $impersonator->id ?? null,
                            'type' => $eventData->type,
                            'event' => $eventData->content,
                            'recorded_at' => $eventData->recordedAt->format('Y-m-d H:i:s.u'),
                        ]);
                        $event->save();
                    }
                });
            }

            //            $siteId = config('statamic.overseer.server.site');
            //            $url = config('statamic.overseer.server.endpoint')."/api/sites/{$siteId}/events";
            //
            //            // Send events to overseer
            //            $response = Http::withToken(config('statamic.overseer.server.token'))
            //                ->post($url, $payload);
        }
    }

    protected function calculateCpuUsage($startUsage, $endUsage): array
    {
        $userTime = ($endUsage['ru_utime.tv_sec'] - $startUsage['ru_utime.tv_sec'])
            + ($endUsage['ru_utime.tv_usec'] - $startUsage['ru_utime.tv_usec']) / 1e6;

        $systemTime = ($endUsage['ru_stime.tv_sec'] - $startUsage['ru_stime.tv_sec'])
            + ($endUsage['ru_stime.tv_usec'] - $startUsage['ru_stime.tv_usec']) / 1e6;

        return [
            'cpu_user_time' => round($userTime, 4),
            'cpu_system_time' => round($systemTime, 4),
        ];
    }
}
