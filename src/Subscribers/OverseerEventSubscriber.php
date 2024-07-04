<?php

namespace Cboxdk\StatamicOverseer\Subscribers;

use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Events\Dispatcher;

class OverseerEventSubscriber
{
    public function subscribe(Dispatcher $events): array
    {

        // check if enabled
        if (! Overseer::enabled()) {
            return [];
        }

        $listeners = [];
        $events = config('statamic.overseer.events', []);

        // Subscribe to events
        foreach ($events as $event => $handler) {
            $listeners[$event] = $handler;
        }

        return $listeners;
    }
}
