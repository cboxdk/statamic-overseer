<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\CollectionTreeSaved;

class StatamicCollectionTreeSaved extends EventHandler
{
    /**
     * @param  CollectionTreeSaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Collection tree saved',
            site: $event->tree->site()->handle(),
            tree: $event->tree->handle()
        ));
    }
}
