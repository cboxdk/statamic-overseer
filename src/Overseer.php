<?php

namespace Cboxdk\StatamicOverseer;

class Overseer
{

    protected array $events = [];

    public function enabled(): bool
    {
        return config('statamic.overseer.enabled', false);
    }

    public function subscribe($event, $handler): void
    {
        $this->events[$event] = $handler;
    }
}