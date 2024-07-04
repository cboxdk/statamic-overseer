<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\FieldsetDeleted;

class StatamicFieldsetDeleted extends EventHandler
{
    /**
     * @param  FieldsetDeleted  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Fieldset deleted',
            model_type: 'fieldset',
            model_id: $event->fieldset->handle(),
        ));
    }
}
