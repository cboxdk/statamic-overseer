<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Facades\Overseer;

abstract class EventHandler
{

    public $event = [];

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
    abstract public function handle($event): void;

    public function track(): void
    {
        Overseer::trackEvent(new Event('event', $this->event));
    }

    public function audit(string $message, array $parameters = [])
    {
        Overseer::addMessage(new Audit($message, $parameters));
    }

}