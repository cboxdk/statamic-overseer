<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\BlueprintDeleted;

class StatamicBlueprintDeleted extends EventHandler
{
    /**
     * @param  BlueprintDeleted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Blueprint deleted',
            properties: [
                'blueprint' => $event->blueprint->toArray(),
            ],
        ));
    }
}
