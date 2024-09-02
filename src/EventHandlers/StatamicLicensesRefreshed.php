<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\LicensesRefreshed;

class StatamicLicensesRefreshed extends EventHandler
{
    /**
     * @param  LicensesRefreshed  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'License refreshed',
        ));
    }
}
