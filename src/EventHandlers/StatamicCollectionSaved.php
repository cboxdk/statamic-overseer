<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\CollectionSaved;

class StatamicCollectionSaved extends EventHandler
{
    /**
     * @param  CollectionSaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Collection saved',
            properties: [
                'collection' => $event->collection->toArray(),
            ],
            collection: $event->collection->handle(),
        ));
    }
}
