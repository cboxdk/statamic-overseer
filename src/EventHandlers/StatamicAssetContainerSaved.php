<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\AssetContainerSaved;

class StatamicAssetContainerSaved extends EventHandler
{
    /**
     * @param  AssetContainerSaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Asset container saved',
            properties: [
                'collection' => $event->container->toArray(),
            ],
            asset_container: $event->container->handle(),
        ));
    }
}
