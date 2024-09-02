<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\StacheCleared;

class StatamicStacheCleared extends EventHandler
{
    /**
     * @param  StacheCleared  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Stache cleared',
        ));
    }
}
