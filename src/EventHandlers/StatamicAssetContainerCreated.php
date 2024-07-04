<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\AssetContainerCreated;

class StatamicAssetContainerCreated extends EventHandler
{
    /**
     * @param  AssetContainerCreated  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Asset container created',
            properties: [
                'collection' => $event->container->toArray(),
            ],
            model_type: 'asset_container',
            model_id: $event->container->handle(),
        ));
    }
}
