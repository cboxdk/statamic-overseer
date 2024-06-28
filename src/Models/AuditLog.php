<?php

namespace Cboxdk\StatamicOverseer\Models;

use Illuminate\Database\Eloquent\Model;

class AuditLog extends Model
{

    protected $guarded = [];

    protected $casts = [
        'ip_addresses' => 'array',
        'old_values' => 'array',
        'new_values' => 'array',
        'additional_info' => 'array',
    ];
}