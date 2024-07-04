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
        'impersonator_id',
        'collection',
        'taxonomy',
        'global',
        'asset_container',
        'tree',
        'entry_id',
        'term_handle',
        'asset_id',
        'global_set',
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
}
