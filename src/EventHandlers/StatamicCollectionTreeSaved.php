<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Statamic\Events\CollectionTreeSaved;

class StatamicCollectionTreeSaved extends EventHandler
{

    /**
     * @param CollectionTreeSaved $event
     * @return void
     */
    public function handle($event): void
    {

        $this->event = [
            ...$this->event,
            'id' => $event->tree->handle(),
            'name' => \Statamic\Facades\Collection::find($event->tree->handle())->title(),
            'site' => $event->tree->site()->handle(),
        ];
        $this->track();
        $this->audit('Collection tree saved', [
            'id' => $event->tree->handle(),
            'name' => \Statamic\Facades\Collection::find($event->tree->handle())->title(),
            'site' => $event->tree->site()->handle(),
        ]);
    }
}