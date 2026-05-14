<?php

use App\Jobs\SyncDxnLeadToKlaviyo;
use App\Models\DxnLead;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('dxn:retry-klaviyo-leads {--limit=50} {--failed-age=15} {--stuck-age=15}', function () {
    $limit = max(1, min(500, (int) $this->option('limit')));
    $failedAge = max(1, (int) $this->option('failed-age'));
    $stuckAge = max(1, (int) $this->option('stuck-age'));
    $now = now();

    $leads = DxnLead::query()
        ->where('klaviyo_synced', false)
        ->where(function ($query) use ($failedAge, $stuckAge, $now) {
            $query
                ->where('klaviyo_sync_status', DxnLead::KLAVIYO_STATUS_PENDING)
                ->orWhere(function ($query) use ($now) {
                    $query
                        ->where('klaviyo_sync_status', DxnLead::KLAVIYO_STATUS_RETRYING)
                        ->where(function ($query) use ($now) {
                            $query
                                ->whereNull('klaviyo_next_retry_at')
                                ->orWhere('klaviyo_next_retry_at', '<=', $now);
                        });
                })
                ->orWhere(function ($query) use ($failedAge, $now) {
                    $query
                        ->where('klaviyo_sync_status', DxnLead::KLAVIYO_STATUS_FAILED)
                        ->where(function ($query) use ($failedAge, $now) {
                            $query
                                ->whereNull('klaviyo_last_attempted_at')
                                ->orWhere('klaviyo_last_attempted_at', '<=', $now->copy()->subMinutes($failedAge));
                        });
                })
                ->orWhere(function ($query) use ($stuckAge, $now) {
                    $query
                        ->where('klaviyo_sync_status', DxnLead::KLAVIYO_STATUS_SYNCING)
                        ->where('klaviyo_last_attempted_at', '<=', $now->copy()->subMinutes($stuckAge));
                });
        })
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
