<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\StaticCacheCleared;

class StatamicStaticCacheCleared extends EventHandler
{
    /**
     * @param  StaticCacheCleared  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Static Cache cleared',
        ));
    }
}
