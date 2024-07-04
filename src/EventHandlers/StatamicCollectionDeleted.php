<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\CollectionDeleted;

class StatamicCollectionDeleted extends EventHandler
{
    /**
     * @param  CollectionDeleted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Collection deleted',
            properties: [
                'collection' => $event->collection->toArray(),
            ],
            collection: $event->collection->handle(),
        ));
    }
}
