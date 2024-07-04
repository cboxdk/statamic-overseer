<?php

namespace Cboxdk\StatamicOverseer\Models;

use Illuminate\Database\Eloquent\Model;
use Statamic\Facades\User;

class OverseerEvent extends Model
{
    public function getConnectionName()
    {
        return config('statamic.overseer.storage.connection');
    }

    protected $fillable = [
        'execution_id',
        'user_id',
        'impersonator_id',
        'type',
        'event',
        'recorded_at',
    ];

    protected $casts = [
        'event' => 'array',
        'recorded_at' => 'datetime:Y-m-d H:i:s.u',
    ];

    public function user()
    {
        if ($this->user_id) {
            return User::find($this->user_id);
        }
    }

    public function impersonator()
    {
        if ($this->impersonator_id) {
            return User::find($this->impersonator_id);
        }
    }
}
