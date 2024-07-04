<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\EntryDeleted;

class StatamicEntryDeleted extends EventHandler
{
    /**
     * @param  EntryDeleted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Entry deleted',
            properties: [
                'entry' => $event->entry->toArray(),
            ],
            site: $event->entry->site()->handle(),
            model_type: 'entry',
            model_handle: $event->entry->collection()->handle(),
            model_id: $event->entry->id(),
        ));
    }
}
