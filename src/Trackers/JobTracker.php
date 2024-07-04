<?php

namespace Cboxdk\StatamicOverseer\Trackers;

use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Statamic\Support\Traits\Hookable;

class JobTracker extends Tracker
{
    use Hookable;

    public function register($app)
    {
        $app['events']->listen(JobProcessed::class, [$this, 'trackJobProcessed']);
        $app['events']->listen(JobFailed::class, [$this, 'trackJobFailed']);
    }

    public function trackJobProcessed(JobProcessed $event)
    {
        if (! Overseer::isTracking()) {
            return;
        }

        $payload = $event->job->payload();

        $job = isset($payload['data']['command'])
            ? get_class($payload['data']['command'])
            : $payload['job'];

        if (in_array($job, $this->options['ignore_jobs'])) {
            return;
        }

        $log = new Event('job', [
            'connection' => $event->job->getConnectionName(),
            'queue' => $event->job->getQueue(),
            'name' => $payload['displayName'],
            'tries' => $payload['maxTries'],
            'timeout' => $payload['timeout'],
            'data' => $payload,
        ]);
        Overseer::trackEvent($log);
    }

    /**
     * Determine if the event should be ignored.
     *
     * @param  mixed  $event
     * @return bool
     */
    private function shouldIgnore($event)
    {
        return in_array($event->command, array_merge($this->options['ignore'] ?? [], [
            'schedule:run',
            'schedule:finish',
            'package:discover',
        ]));
    }
}
