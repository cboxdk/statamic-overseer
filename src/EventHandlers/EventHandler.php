<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Facades\Overseer;

abstract class EventHandler
{
    public array $event = [];

    public function run($event)
    {
        if (! Overseer::isTracking()) {
            return;
        }

        $this->event = [
            'event' => $event::class,
        ];

        $this->handle($event);
    }

    abstract public function handle(Object $event): void;

    public function track($type = 'event'): void
    {
        Overseer::trackEvent(new Event($type, $this->event));
    }
}
