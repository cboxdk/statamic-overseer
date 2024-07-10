<?php

namespace Cboxdk\StatamicOverseer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExecutionResourceShow extends JsonResource
{
    public function toArray($request)
    {
        return [
            ...parent::toArray($request),
            'initiator' => $this->initiator(),
            'events' => $this->events()->get()->map->toArray(),
            'audits' => $this->audits()->get()->map(fn ($audit) => [
                ...$audit->toArray(),
                'subject' => $audit->subject(),
            ]),
            'user' => $this->user(),
            'impersonator' => $this->impersonator(),
        ];
    }
}
