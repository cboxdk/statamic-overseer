<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\BlueprintCreated;

class StatamicBlueprintCreated extends EventHandler
{
    /**
     * @param  BlueprintCreated  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Blueprint created',
            properties: [
                'blueprint' => $event->blueprint->toArray(),
            ],
        ));
    }
}
