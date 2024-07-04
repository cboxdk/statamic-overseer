<?php

namespace Cboxdk\StatamicOverseer\Models;

use Illuminate\Database\Eloquent\Model;
use Statamic\Facades\User;

class OverseerAudit extends Model
{
    public function getConnectionName()
    {
        return config('statamic.overseer.storage.connection');
    }

    protected $fillable = [
        'execution_id',
        'user_id',
        'model_type',
        'model_handle',
        'model_id',
        'site',
        'message',
        'properties',
    ];

    protected $casts = [
        'properties' => 'array',
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

    public function execution()
    {
        return $this->belongsTo(OverseerExecution::class, 'id', 'execution_id');
    }
}
