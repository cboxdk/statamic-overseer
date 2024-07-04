<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Auth\Events\Failed;
use Statamic\Facades\User;

class FailedLoginHandler extends EventHandler
{
    /**
     * @param  Failed  $event
     */
    public function handle($event): void
    {
        $properties = [
            'email' => $event->credentials['email'] ?? '',
        ];

        // Resolve the user from e-mail
        $user = User::findByEmail($event->credentials['email'] ?? '');
        if ($user) {
            $properties['user_id'] = $user->id;
            Overseer::setUser($user);
        }

        $this->event = [
            ...$this->event,
            ...$properties,
        ];

        $this->track();


        Overseer::addMessage(new Audit(
            message: 'Login failed',
            properties: $properties,
        ));
    }
}
