<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\BlueprintSaved;

class StatamicBlueprintSaved extends EventHandler
{
    /**
     * @param  BlueprintSaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Blueprint saved',
            properties: [
                'blueprint' => $event->blueprint->toArray(),
            ],
            model_type: 'blueprint',
            model_id: $event->blueprint->handle(),
        ));
    }
}
