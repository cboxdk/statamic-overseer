<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\AssetContainerDeleted;

class StatamicAssetContainerDeleted extends EventHandler
{
    /**
     * @param  AssetContainerDeleted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Asset container deleted',
            properties: [
                'collection' => $event->container->toArray(),
            ],
            asset_container: $event->container->handle(),
        ));
    }
}