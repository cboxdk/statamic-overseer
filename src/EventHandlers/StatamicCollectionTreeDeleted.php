<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\CollectionTreeDeleted;

class StatamicCollectionTreeDeleted extends EventHandler
{
    /**
     * @param  CollectionTreeDeleted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Collection tree deleted',
            properties: [
                'collection' => $event->tree->toArray(),
            ],
            model_type: 'tree',
            model_id: $event->tree->handle(),
        ));
    }
}
