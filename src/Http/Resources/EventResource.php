<?php

namespace Cboxdk\StatamicOverseer\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EventResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            ...parent::toArray($request),
            'user' => $this->user(),
            'impersonator' => $this->impersonator(),
        ];
    }
}
