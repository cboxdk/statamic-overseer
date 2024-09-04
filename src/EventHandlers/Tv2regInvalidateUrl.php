<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Facades\Entry;

class Tv2regInvalidateUrl extends EventHandler
{
    /**
     * @param  InvalidateUrl  $event
     */
    public function handle($event): void
    {
        $this->track();

        // Resolve entry
        $entry = Entry::findByUri($event->url);

        Overseer::addMessage(new Audit(
            message: 'Invalidate Static Cache URL',
            properties: [
                'url' => $event->url,
            ],
            model_type: 'entry',
            model_handle: $entry?->collectionHandle() ?? null,
            model_id: $entry?->id() ?? null,
        ));
    }
}
