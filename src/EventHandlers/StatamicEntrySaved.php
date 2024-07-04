<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\EntrySaved;

class StatamicEntrySaved extends EventHandler
{
    /**
     * @param  EntrySaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Entry saved',
            site: $event->entry->site()->handle(),
            collection: $event->entry->collection()->handle(),
            entry_id: $event->entry->id(),
        ));
    }
}
