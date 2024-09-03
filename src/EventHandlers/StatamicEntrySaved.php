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

        $message = 'Entry saved ('.$entry->status().')';
        if ($entry->isDirty('published')) {
            if ($entry->status() === 'published') {
                $message = 'Entry saved and published';
            } elseif ($entry->status() === 'scheduled') {
                $message = 'Entry saved and scheduled';
            } elseif ($entry->status() === 'draft') {
                $message = 'Entry saved and unpublished';
            }
        }

        Overseer::addMessage(new Audit(
            message: $message,
            properties: [
                'status' => $entry->status(),
                'published' => $entry->published(),
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
