<?php

namespace Cboxdk\StatamicOverseer\Trackers;

use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Console\Events\CommandFinished;
use Statamic\Support\Traits\Hookable;

class CommandTracker extends Tracker
{
    use Hookable;

    public function register($app)
    {
        $app['events']->listen(CommandFinished::class, [$this, 'trackCommand']);
    }

    public function trackCommand(CommandFinished $event)
    {
        if (! Overseer::isTracking()) {
            return;
        }

        if ($this->shouldIgnore($event)) {
            Overseer::ignoreChain();

            return;
        }

        $log = new Event('command', [
            'command' => $event->command ?? $event->input->getArguments()['command'] ?? null,
            'exit_code' => $event->exitCode,
            'arguments' => $event->input->getArguments(),
            'options' => $event->input->getOptions(),
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
