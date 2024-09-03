<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Tv2regionerne\StatamicCache\Events\InvalidateUrls;

class Tv2regInvalidateUrls extends EventHandler
{
    /**
     * @param  InvalidateUrls  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Static cache invalidate urls',
            properties: [
                'urls' => $event->urls,
            ],
            model_type: 'user',
            model_id: $event->authenticatedUser?->getAuthIdentifier() ?? null,
        ));
    }
}
