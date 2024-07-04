<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Auth\Events\PasswordReset;

class PasswordResetHandler extends EventHandler
{
    /**
     * @param  PasswordReset  $event
     */
    public function handle($event): void
    {
        $user = $event->user;
        Overseer::setUser($user);
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Password reset',
        ));
    }
}
