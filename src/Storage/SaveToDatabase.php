<?php

namespace Cboxdk\StatamicOverseer\Storage;

use Cboxdk\StatamicOverseer\Audit;
use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Jobs\PersistOverseerEvent;
use Cboxdk\StatamicOverseer\Models\OverseerAudit;
use Cboxdk\StatamicOverseer\Models\OverseerEvent;
use Cboxdk\StatamicOverseer\Models\OverseerExecution;

class SaveToDatabase
{
    public static function queue(array $events, array $audits, $executionId, $duration, $memory, $cpuUsage, $user, $impersonator)
    {
        PersistOverseerEvent::dispatch($events, $audits, $executionId, $duration, $memory, $cpuUsage, $user, $impersonator);
    }

    public static function sync(array $events, array $audits, $executionId, $duration, $memory, $cpuUsage, $user, $impersonator)
    {
        rescue(function () use ($events, $audits, $executionId, $duration, $memory, $cpuUsage, $user, $impersonator) {
            $execution = new OverseerExecution();
            $execution->id = $executionId;
            $execution->fill([
                'user_id' => $user->id ?? null,
                'impersonator_id' => $impersonator->id ?? null,
                'host' => gethostname(),
                'pid' => getmypid(),
                'duration' => $duration,
                'memory' => $memory,
                ...$cpuUsage,
            ]);
            $execution->save();

            /** @var Audit $event */
            foreach ($audits as $event) {
                $audit = new OverseerAudit();
                $audit->fill([
                    'execution_id' => $executionId,
                    'user_id' => $user->id ?? null,
                    'impersonator_id' => $impersonator->id ?? null,
                    ...$event->toArray(),
                ]);
                $audit->save();
            }

            /** @var Event $eventData */
            foreach ($events as $eventData) {
                $event = new OverseerEvent();
                $event->fill([
                    'execution_id' => $executionId,
                    'user_id' => $user->id ?? null,
                    'impersonator_id' => $impersonator->id ?? null,
                    'type' => $eventData->type,
                    'event' => $eventData->content,
                    'recorded_at' => $eventData->recordedAt->format('Y-m-d H:i:s.u'),
                ]);
                $event->save();
            }
        });
    }
}
