<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\UrlInvalidated;
use Statamic\Events\UserCreated;

class StatamicUrlInvalidated extends EventHandler
{
    /**
     * @param  UrlInvalidated  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'URL invalidated',
            properties: [
                'user' => $event->authenticatedUser?->toArray(),
                'url' => $event->url,
            ],
            model_type: 'user',
            model_id: $event->authenticatedUser?->id,
        ));
    }
}
