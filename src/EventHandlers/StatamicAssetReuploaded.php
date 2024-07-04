<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\AssetReuploaded;

class StatamicAssetReuploaded extends EventHandler
{
    /**
     * @param  AssetReuploaded  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Asset Reuploaded',
            properties: [
                'asset' => $event->asset->toArray(),
            ],
            asset_container: $event->asset->container()->handle(),
            asset_id: $event->asset->id(),
        ));
    }
}
