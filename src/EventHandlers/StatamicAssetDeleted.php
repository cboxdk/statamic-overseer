<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\AssetUploaded;

class StatamicAssetDeleted extends EventHandler
{
    /**
     * @param  AssetUploaded  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Asset uploaded',
            properties: [
                'asset' => $event->asset->toArray(),
            ],
            model_type: 'asset',
            model_handle: $event->asset->container()->handle(),
            model_id: $event->asset->id(),
        ));
    }
}
