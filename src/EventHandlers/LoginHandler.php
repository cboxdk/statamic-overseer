<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Auth\Events\Login;

class LoginHandler extends EventHandler
{
    /**
     * @param  Login  $event
     */
    public function handle($event): void
    {
        $this->event['guard'] = $event->guard;
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'User logged in',
            properties: [
                'guard' => $event->guard,
            ],
            model_type: 'user',
            model_id: $event->user->getAuthIdentifier(),
        ));
    }
}
