<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\UserGroupSaved;

class StatamicUserGroupSaved extends EventHandler
{
    /**
     * @param  UserGroupSaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'User Group saved',
            properties: [
                'user_group' => $event->group->toArray(),
            ],
            model_type: 'group',
            model_id: $event->group->id,
        ));
    }
}
