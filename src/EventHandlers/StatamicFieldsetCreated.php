<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\FieldsetCreated;
use Statamic\Fields\Fieldset;

class StatamicFieldsetCreated extends EventHandler
{
    /**
     * @param  FieldsetCreated  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Fieldset created',
            model_type: 'fieldset',
            model_id: $event->fieldset->handle(),
        ));
    }
}
