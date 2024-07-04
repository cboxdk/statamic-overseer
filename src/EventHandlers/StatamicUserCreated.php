<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\UserCreated;

class StatamicUserCreated extends EventHandler
{
    /**
     * @param  UserCreated  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'User created',
            properties: [
                'user' => $event->user->toArray(),
            ],
        ));
    }
}
