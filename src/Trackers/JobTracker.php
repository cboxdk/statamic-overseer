<?php

namespace Cboxdk\StatamicOverseer\Trackers;

use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Queue\Events\JobFailed;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Queue;
use Statamic\Facades\Blink;
use Statamic\Facades\User;
use Statamic\Support\Traits\Hookable;

class JobTracker extends Tracker
{
    use Hookable;

    public function register($app)
    {
        Queue::createPayloadUsing(function ($connection, $queue, $payload) {
            return [
                'user' => Auth::user()?->id ?? null,
            ];
        });

        $app['events']->listen(JobProcessing::class, [$this, 'trackJobProcessing']);
        $app['events']->listen(JobProcessed::class, [$this, 'trackJobProcessed']);
        $app['events']->listen(JobFailed::class, [$this, 'trackJobFailed']);
    }

    public function trackJobProcessing(JobProcessing $event)
    {
        $uuid = $event->job->uuid();
        Blink::put('overseer-job-starttime-'. $uuid, microtime(true));
    }

    public function trackJobProcessed(JobProcessed $event)
    {
        if (! Overseer::isTracking()) {
            return;
        }

        $payload = $event->job->payload();

        $job = $payload['data']['commandName'] ?? $payload['displayName'] ?? $payload['job'];

        if (in_array($job, $this->options['ignore_jobs'])) {
            Overseer::ignoreChain();

            return;
        }

        $user = $payload['user'] ?? null;
        if ($user) {
            $user = User::find($user);
            Overseer::setUser($user);
        }

        $log = new Event('job', [
            'connection' => $event->job->getConnectionName(),
            'queue' => $event->job->getQueue(),
            'name' => $payload['displayName'],
            'tries' => $payload['maxTries'],
            'timeout' => $payload['timeout'],
        ]);

        $startTime = Blink::get('overseer-job-starttime-'. $event->job->uuid(), $payload['pushedAt']);
        $duration = $startTime ? floor((microtime(true) - $startTime) * 1000) : null;

        Overseer::trackEvent($log);
        Overseer::store($duration);
        Overseer::reset();
    }

    public function trackJobFailed(JobFailed $event)
    {
        if (! Overseer::isTracking()) {
            return;
        }

        $payload = $event->job->payload();

        $job = $payload['data']['commandName'] ?? $payload['displayName'] ?? $payload['job'];

        if (in_array($job, $this->options['ignore_jobs'])) {
            Overseer::ignoreChain();

            return;
        }

        $user = $payload['user'] ?? null;
        if ($user) {
            $user = User::find($user);
            Overseer::setUser($user);
        }

        $log = new Event('job', [
            'connection' => $event->job->getConnectionName(),
            'queue' => $event->job->getQueue(),
            'name' => $payload['displayName'],
            'tries' => $payload['maxTries'],
            'timeout' => $payload['timeout'],
            'data' => [
                'exception' => $event->exception->getMessage(),
            ],
        ]);
        Overseer::trackEvent($log);
        Overseer::store();
        Overseer::reset();
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
