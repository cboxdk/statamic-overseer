<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\ImpersonationStarted;

class StatamicImpersonationStarted extends EventHandler
{
    /**
     * @param  ImpersonationStarted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'User impersonation is started',
            properties: [
                'impersonator' => $event->impersonator->toArray(),
                'impersonated' => $event->impersonated->toArray(),
            ],
            model_type: 'user',
            model_id: $event->impersonator->id,
        ));
    }
}
