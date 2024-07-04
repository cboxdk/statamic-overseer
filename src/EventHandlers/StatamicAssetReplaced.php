<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\AssetReplaced;

class StatamicAssetReplaced extends EventHandler
{
    /**
     * @param  AssetReplaced  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Asset replaced',
            properties: [
                'asset' => $event->newAsset->toArray(),
                'original' => $event->originalAsset->toArray(),
            ],
            asset_container: $event->newAsset->container()->handle(),
            asset_id: $event->newAsset->id(),
        ));
    }
}
