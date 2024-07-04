<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Statamic\Events\BlueprintCreated;
use Statamic\Fields\Blueprint;

class StatamicBlueprintCreated extends EventHandler
{
    /**
     * @param  BlueprintCreated  $event
     */
    public function handle($event): void
    {
        $this->track();

        /** @var Blueprint $blueprint */
        $blueprint = $event->blueprint;
        $blueprint->

        Overseer::addMessage(new Audit(
            message: 'Blueprint created',
            properties: [
                'blueprint' => $event->blueprint->toArray(),
            ],
            model_type: 'blueprint',
            model_id: $event->blueprint->handle(),
        ));
    }
}
