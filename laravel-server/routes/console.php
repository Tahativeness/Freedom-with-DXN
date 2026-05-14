<?php

use App\Jobs\SyncDxnLeadToKlaviyo;
use App\Models\DxnLead;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('dxn:retry-klaviyo-leads {--limit=50}', function () {
    $limit = max(1, min(500, (int) $this->option('limit')));

    $leads = DxnLead::query()
        ->where('klaviyo_synced', false)
        ->whereIn('klaviyo_sync_status', [
            DxnLead::KLAVIYO_STATUS_FAILED,
            DxnLead::KLAVIYO_STATUS_RETRYING,
            DxnLead::KLAVIYO_STATUS_PENDING,
            DxnLead::KLAVIYO_STATUS_QUEUED,
        ])
        ->orderBy('id')
        ->limit($limit)
        ->get();

    foreach ($leads as $lead) {
        $lead->forceFill([
            'klaviyo_sync_status' => DxnLead::KLAVIYO_STATUS_QUEUED,
            'klaviyo_error' => null,
            'klaviyo_next_retry_at' => null,
        ])->save();

        SyncDxnLeadToKlaviyo::dispatch($lead->id)
            ->onQueue(config('services.klaviyo.queue', 'klaviyo'));
    }

    $this->info('Queued ' . $leads->count() . ' DXN lead(s) for Klaviyo sync.');
})->purpose('Retry failed or pending DXN lead Klaviyo sync jobs');
