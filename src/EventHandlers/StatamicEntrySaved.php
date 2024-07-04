<?php

namespace Cboxdk\StatamicOverseer\EventHandlers;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Statamic\Entries\Entry;
use Statamic\Events\EntrySaved;

class StatamicEntrySaved extends EventHandler
{
    /**
     * @param  EntrySaved  $event
     */
    public function handle($event): void
    {
        /** @var Entry $entry */
        $entry = $event->entry;
        $currentValues = $entry->getCurrentDirtyStateAttributes();
        $originalValues = $entry->getOriginal();

        $changedAttributes = [];
        $diff = [];

        foreach ($currentValues as $key => $currentValue) {
            if (array_key_exists($key, $originalValues) && $currentValue !== $originalValues[$key]) {
                $changedAttributes[] = $key;
                $diff['original'][$key] = $originalValues[$key];
                $diff['current'][$key] = $currentValue;
            }
        }

        $this->event['changed_attributes'] = $changedAttributes;
        $this->event['diff'] = $diff;

        $this->track();

        Overseer::addMessage(new Audit(
            message: 'Entry saved',
            properties: [
                'changed_attributes' => $changedAttributes,
                'diff' => $diff,
            ],
            site: $event->entry->site()->handle(),
            model_type: 'entry',
            model_handle: $event->entry->collection()->handle(),
            model_id: $event->entry->id(),
        ));
    }
}
