<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Statamic\Support\Str;

class GenericHandler extends EventHandler
{
    /**
     * @param  mixed  $event
     */
    public function handle($event): void
    {
        $type = Str::of($event::class)->snake()->remove('\\')->remove('_events')->toString();
        $this->event['event'] = json_decode(json_encode($event), true);
        $this->track($type);
    }
}
