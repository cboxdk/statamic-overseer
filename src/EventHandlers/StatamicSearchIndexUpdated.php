<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\SearchIndexUpdated;

class StatamicSearchIndexUpdated extends EventHandler
{
    /**
     * @param  SearchIndexUpdated  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Search Index Updated',
            properties: [
                'index' => (string) $event->index,
            ]
        ));
    }
}
