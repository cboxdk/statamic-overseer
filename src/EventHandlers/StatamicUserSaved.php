<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\UserSaved;

class StatamicUserSaved extends EventHandler
{
    /**
     * @param  UserSaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'User saved',
            properties: [
                'user' => $event->user->toArray(),
            ],
        ));
    }
}
