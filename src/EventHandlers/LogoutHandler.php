<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\Logout;

class LogoutHandler extends EventHandler
{
    /**
     * @param  Logout  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'User logged out',
        ));
    }
}
