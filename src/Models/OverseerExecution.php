<?php

namespace Cboxdk\StatamicOverseer\Models;

use Illuminate\Database\Eloquent\Model;
use Statamic\Facades\User;

class OverseerExecution extends Model
{
    public function getConnectionName()
    {
        return config('statamic.overseer.storage.connection');
    }

    protected $fillable = [
        'execution_id',
        'user_id',
        'impersonator_id',
        'host',
        'pid',
        'duration',
        'memory',
        'cpu_user_time',
        'cpu_system_time',
        'cpu_usage_percentage',
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function audits()
    {
        return $this->hasMany(OverseerAudit::class, 'execution_id', 'execution_id');
    }

    public function events()
    {
        return $this->hasMany(OverseerEvent::class, 'execution_id', 'execution_id');
    }

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
