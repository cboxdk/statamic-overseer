<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\CollectionTreeSaved;
use Statamic\Events\EntrySaved;

class StatamicEntrySaved extends EventHandler
{

    private ?string $message = null;

    /**
     * @param EntrySaved $event
     * @return array
     */
    public function handle($event): void
    {

    }
}