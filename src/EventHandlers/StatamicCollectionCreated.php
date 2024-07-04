<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\CollectionCreated;

class StatamicCollectionCreated extends EventHandler
{
    /**
     * @param  CollectionCreated  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Collection created',
            properties: [
                'collection' => $event->collection->toArray(),
            ],
            model_type: 'collection',
            model_id: $event->collection->handle(),
        ));
    }
}
