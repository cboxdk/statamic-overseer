<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\UserGroupDeleted;

class StatamicUserGroupDeleted extends EventHandler
{
    /**
     * @param  UserGroupDeleted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'User Group deleted',
            properties: [
                'user_group' => $event->group->toArray(),
            ],
            groups: $event->group->id(),
        ));
    }
}
