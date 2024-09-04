<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\SiteCreated;

class StatamicSiteCreated extends EventHandler
{
    /**
     * @param  SiteCreated  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Site created',
            properties: [
                'site' => $event->site->toArray(),
            ],
            model_type: 'site',
            model_handle: $event->site->handle(),
        ));
    }
}
