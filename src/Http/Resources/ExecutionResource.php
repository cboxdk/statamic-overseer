<?php

namespace Cboxdk\StatamicOverseer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ExecutionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            ...parent::toArray($request),
            'initiator' => $this->initiator(),
            'event_count' => $this->events()->count(),
            'audit_count' => $this->audits()->count(),
            'user' => $this->user(),
            'impersonator' => $this->impersonator(),
        ];
    }
}
