<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\UserPasswordChanged;

class StatamicUserPasswordChanged extends EventHandler
{
    /**
     * @param  UserPasswordChanged  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'User password has been changed',
            properties: [
                'user' => $event->user->toArray(),
            ],
            model_type: 'user',
            model_id: $event->user->id,
        ));
    }
}
