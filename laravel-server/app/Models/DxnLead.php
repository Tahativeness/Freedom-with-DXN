<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DxnLead extends Model
{
    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'country_code',
        'country_name',
        'interest',
        'seriousness',
        'goal',
        'learn',
        'score',
        'source',
        'submitted_at',
        'utm_source',
        'utm_medium',
        'utm_campaign',
        'payload',
        'klaviyo_synced',
        'klaviyo_sync_status',
        'klaviyo_synced_at',
        'klaviyo_error',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'payload' => 'array',
        'klaviyo_synced' => 'boolean',
        'klaviyo_synced_at' => 'datetime',
    ];
}
