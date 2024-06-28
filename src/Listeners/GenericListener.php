<?php

namespace Cboxdk\StatamicOverseer\Listeners;

use Cboxdk\StatamicOverseer\Models\AuditLog;
use Cboxdk\StatamicOverseer\Traits\ListensToEvents;

class GenericListener
{
    use ListensToEvents;

    public function handle($event): void
    {
        $model = $event->entry ?? null;
        $this->createEvent($event, $model);
    }
}