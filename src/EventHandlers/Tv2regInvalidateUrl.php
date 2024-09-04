<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;

class Tv2regInvalidateUrl extends EventHandler
{
    /**
     * @param  InvalidateUrl  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Static cache invalidate urls',
            properties: [
                'url' => $event->url,
            ],
            model_type: 'user',
            model_id: $event->authenticatedUser?->getAuthIdentifier() ?? null,
        ));
    }
}
