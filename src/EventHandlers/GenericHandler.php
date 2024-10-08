<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

class GenericHandler extends EventHandler
{
    /**
     * @param  mixed  $event
     */
    public function handle($event): void
    {
        $this->event['class'] = $event::class;
        $this->event['event'] = json_decode(json_encode($event), true);
        $this->track();
    }
}
