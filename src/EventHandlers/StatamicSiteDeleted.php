<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\SiteCreated;
use Statamic\Events\SiteDeleted;
use Statamic\Events\SiteSaved;

class StatamicSiteDeleted extends EventHandler
{
    /**
     * @param  SiteDeleted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Site deleted',
            properties: [
                'site' => $event->site->toArray(),
            ],
            model_type: 'site',
            model_handle: $event->site->handle(),
        ));
    }
}
