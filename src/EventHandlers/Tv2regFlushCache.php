<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Tv2regionerne\StatamicCache\Events\FlushCache;

class Tv2regFlushCache extends EventHandler
{
    /**
     * @param  FlushCache  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Static cache flushed',
        ));
    }
}
