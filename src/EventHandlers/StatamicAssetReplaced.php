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
            model_type: 'asset',
            model_handle: $event->newAsset->container()->handle(),
            model_id: $event->newAsset->id(),
        ));
    }
}
