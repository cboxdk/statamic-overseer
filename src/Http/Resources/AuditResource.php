<?php

namespace Cboxdk\StatamicOverseer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class AuditResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            ...parent::toArray($request),
            'user' => $this->user(),
            'impersonator' => $this->impersonator(),
            'initiator' => $this->initiator(),
            'subject' => $this->subject(),
        ];
    }
}
