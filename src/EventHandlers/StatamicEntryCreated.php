<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\EntryCreated;

class StatamicEntryCreated extends EventHandler
{
    /**
     * @param  EntryCreated  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Entry created',
            properties: [
                'entry' => $event->entry->toArray(),
            ],
            site: $event->entry->site()->handle(),
            collection: $event->entry->collection()->handle(),
            entry_id: $event->entry->id(),
        ));
    }
}
