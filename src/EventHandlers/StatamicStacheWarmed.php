<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\StacheWarmed;

class StatamicStacheWarmed extends EventHandler
{
    /**
     * @param  StacheWarmed  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Stache warmed',
        ));
    }
}
