<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Events\FieldsetSaved;

class StatamicFieldsetSaved extends EventHandler
{
    /**
     * @param  FieldsetSaved  $event
     */
    public function handle($event): void
    {
        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Fieldset saved',
            model_type: 'fieldset',
            model_id: $event->fieldset->handle(),
        ));
    }
}
