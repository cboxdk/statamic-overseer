<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\GlideCacheCleared;

class StatamicGlideCacheCleared extends EventHandler
{
    /**
     * @param  GlideCacheCleared  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Glide Cache cleared',
        ));
    }
}
