<?php

namespace Cboxdk\StatamicOverseer\Models;

use Illuminate\Database\Eloquent\Model;
use Statamic\Facades\Asset;
use Statamic\Facades\Blueprint;
use Statamic\Facades\Entry;
use Statamic\Facades\Term;
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
        return $this->belongsTo(OverseerExecution::class, 'execution_id', 'id');
    }

    public function initiator()
    {
        return $this->execution()->first()?->initiator();
    }

    public function subject()
    {
        return match ($this->model_type) {
            'entry' => Entry::find($this->model_id),
            'term' => Term::find($this->model_id.':'.$this->model_handle),
            'asset' => Asset::find($this->model_id.':'.$this->model_handle),
            'user' => User::find($this->model_id),
            'blueprint' => Blueprint::find($this->model_id),
            default => null,
        };
    }
}
