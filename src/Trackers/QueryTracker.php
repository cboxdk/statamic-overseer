<?php

namespace Cboxdk\StatamicOverseer\Trackers;

use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Database\Events\QueryExecuted;
use Statamic\Support\Str;

class QueryTracker extends Tracker
{
    public function register($app)
    {
        $app['events']->listen(QueryExecuted::class, [$this, 'recordQuery']);
    }

    public function recordQuery(QueryExecuted $event)
    {
        if (! Overseer::isTracking() || ! $this->shouldLog($event)) {
            return;
        }

        $trace = collect(debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS))->take($this->options['trace_max'] ?? 20)->filter(function ($frame) {
            if (! isset($frame['file'])) {
                return false;
            }

            $ignore = [
                base_path('vendor'.DIRECTORY_SEPARATOR.'laravel'),
                dirname(__DIR__, 2),
            ];

            return ! Str::contains($frame['file'], $ignore);
        });

        $event = new Event('query', [
            'connection' => $event->connectionName,
            'bindings' => $event->bindings,
            'sql' => $event->sql,
            'time' => number_format($event->time, 2, '.', ''),
            'slow' => $event->time >= $this->options['slow_query_time'] ?? 100,
            'trace' => $trace,
        ]);
        Overseer::trackEvent($event);
    }

    private function shouldLog(QueryExecuted $event)
    {
        if (in_array($event->connectionName, $this->options['ignore_connections'])) {
            return false;
        }

        if ($this->options['log_only_write'] && ! $this->isWriteQuery($event->sql)) {
            return false;
        }

        return true;
    }

    /**
     * Check if the SQL query is a write operation.
     *
     * @param  string  $sql
     * @return bool
     */
    protected function isWriteQuery($sql)
    {
        // Regex pattern to match write operations
        $pattern = '/^(insert|update|delete|replace)\s/i';

        return preg_match($pattern, $sql) === 1;
    }
}
