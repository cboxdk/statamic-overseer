<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\RevisionSaved;

class StatamicRevisionSaved extends EventHandler
{
    /**
     * @param  RevisionSaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        // Find the type and id
        $parts = explode('/', $event->revision->key());
        $collectionHandle = $parts[1] ?? null;
        $entryId = $parts[3] ?? null;

        Overseer::addMessage(new Audit(
            message: 'Revision saved',
            properties: [
                'revision' => $event->revision->toArray(),
            ],
            model_type: 'entry',
            model_handle: $collectionHandle,
            model_id: $entryId,
        ));
    }
}
