<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\UserDeleted;

class StatamicUserDeleted extends EventHandler
{
    /**
     * @param  UserDeleted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'User deleted',
            properties: [
                'user' => $event->user->toArray(),
            ],
        ));
    }
}
