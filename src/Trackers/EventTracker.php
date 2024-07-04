<?php

namespace Cboxdk\StatamicOverseer\Trackers;

use Statamic\Support\Traits\Hookable;

class EventTracker extends Tracker
{
    use Hookable;
    public function register($app)
    {
        foreach ($this->options['events'] ?? [] as $event => $handler) {
            $app['events']->listen($event, [$handler, 'run']);
        }
    }
}
