<?php

namespace Cboxdk\StatamicOverseer;

use Cboxdk\StatamicOverseer\Storage\SaveToDatabase;
use Illuminate\Support\Facades\Auth;
use Statamic\Facades\User;
use Statamic\Support\Str;

class Overseer
{
    public static array $events = [];

    public static array $audits = [];

    public static $user = null;

    public static $impersonator = null;

    public static bool $shouldTrack = false;

    public static bool $ignoreChain = false;

    public static array $trackers = [];

    public static float $startTime;

    public static array $startCpuUsage;

    public function start($app)
    {
        static::$shouldTrack = true;
        static::$startTime = microtime(true);
        static::$startCpuUsage = getrusage();
    }

    public function reset()
    {
        static::$events = [];
        static::$audits = [];
        static::$user = null;
        static::$impersonator = null;
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

    public function startTime(): float
    {
        return self::$startTime;
    }

    public function disableTracking(): void
    {
        self::$shouldTrack = false;
    }

    public function ignoreChain(): void
    {
        self::$ignoreChain = true;
        self::$shouldTrack = false;
        self::$events = [];
        self::$audits = [];
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

    public function getEvents(): array
    {
        return self::$events;
    }

    public function getAudits(): array
    {
        return self::$audits;
    }

    public function getTrackers(): array
    {
        return self::$trackers;
    }

    public function store($duration = null): void
    {
        // Stop tracking at this point
        self::$shouldTrack = false;

        if (count(static::$events) > 0 || count(static::$audits) > 0) {

            // performance
            $startTime = defined('LARAVEL_START') ? LARAVEL_START : request()->request->server('REQUEST_TIME_FLOAT') ?? null;
            $duration ??= $startTime ? floor((microtime(true) - $startTime) * 1000) : null;
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
                if (config('statamic.overseer.storage.queue.enabled')) {
                    SaveToDatabase::queue($this->getEvents(), $this->getAudits(), $executionId, $duration, $memory, $cpuUsage, $user, $impersonator);
                } else {
                    SaveToDatabase::sync($this->getEvents(), $this->getAudits(), $executionId, $duration, $memory, $cpuUsage, $user, $impersonator);
                }

            }

            // persist to overseer cloud server
            if (config('statamic.overseer.server.enabled')) {
                // Not implemented yet
            }
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
