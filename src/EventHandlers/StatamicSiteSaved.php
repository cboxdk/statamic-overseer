<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\SiteCreated;
use Statamic\Events\SiteSaved;

class StatamicSiteSaved extends EventHandler
{
    /**
     * @param  SiteSaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Site saved',
            properties: [
                'site' => $event->site->toArray(),
            ],
            model_type: 'site',
            model_handle: $event->site->handle(),
        ));
    }
}
