<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DxnLead extends Model
{
    public const KLAVIYO_STATUS_PENDING = 'pending';
    public const KLAVIYO_STATUS_QUEUED = 'queued';
    public const KLAVIYO_STATUS_SYNCING = 'syncing';
    public const KLAVIYO_STATUS_RETRYING = 'retrying';
    public const KLAVIYO_STATUS_SYNCED = 'synced';
    public const KLAVIYO_STATUS_FAILED = 'failed';

    protected $fillable = [
        'name',
        'email',
        'whatsapp',
        'country_code',
        'country_name',
        'address',
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
        'idempotency_key',
        'klaviyo_synced',
        'klaviyo_sync_status',
        'klaviyo_synced_at',
        'klaviyo_error',
        'klaviyo_retry_count',
        'klaviyo_last_attempted_at',
        'klaviyo_next_retry_at',
        'klaviyo_profile_id',
        'klaviyo_subscription_job_id',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'payload' => 'array',
        'klaviyo_synced' => 'boolean',
        'klaviyo_synced_at' => 'datetime',
        'klaviyo_last_attempted_at' => 'datetime',
        'klaviyo_next_retry_at' => 'datetime',
    ];

    public function klaviyoPayload(): array
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'whatsapp' => $this->whatsapp,
            'country_code' => $this->country_code,
            'country_name' => $this->country_name,
            'address' => $this->address,
            'interest' => $this->interest,
            'seriousness' => $this->seriousness,
            'goal' => $this->goal,
            'learn' => $this->learn,
            'score' => $this->score,
            'source' => $this->source,
            'timestamp' => optional($this->submitted_at ?? $this->created_at)->toISOString(),
            'utm_source' => $this->utm_source,
            'utm_medium' => $this->utm_medium,
            'utm_campaign' => $this->utm_campaign,
        ];
    }
}
