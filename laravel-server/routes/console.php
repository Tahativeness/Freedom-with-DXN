<?php

use App\Jobs\SyncDxnLeadToKlaviyo;
use App\Models\DxnLead;
use App\Services\KlaviyoLeadService;
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

Artisan::command('dxn:klaviyo-status', function () {
    $apiKey = config('services.klaviyo.api_key') ?: config('klaviyo.private_api_key');
    $listId = config('services.klaviyo.list_id') ?: config('klaviyo.list_id');
    $revision = config('services.klaviyo.revision') ?: config('klaviyo.revision');
    $baseUrl = config('services.klaviyo.base_url') ?: config('klaviyo.base_url');
    $queue = config('services.klaviyo.queue') ?: config('klaviyo.queue');

    $this->line('Private API key loaded: ' . (filled($apiKey) ? 'yes' : 'no'));
    $this->line('Private API key format: ' . (str_starts_with((string) $apiKey, 'pk_') ? 'looks valid' : 'expected pk_...'));
    $this->line('List ID loaded: ' . (filled($listId) ? 'yes' : 'no'));
    $this->line('Klaviyo revision: ' . (string) $revision);
    $this->line('Base URL: ' . (string) $baseUrl);
    $this->line('Queue connection: ' . config('queue.default'));
    $this->line('Klaviyo queue: ' . (string) $queue);

    if (! filled($apiKey) || ! filled($listId)) {
        $this->warn('Set KLAVIYO_PRIVATE_API_KEY and KLAVIYO_LIST_ID in laravel-server/.env, then run php artisan config:clear.');
    }
})->purpose('Check Klaviyo lead sync configuration without exposing secrets');

Artisan::command('dxn:test-klaviyo {email : Email address to create/update and subscribe in Klaviyo} {--name=Klaviyo Test Lead}', function (string $email) {
    $result = app(KlaviyoLeadService::class)->syncLead([
        'name' => (string) $this->option('name'),
        'email' => $email,
        'whatsapp' => '',
        'country_code' => '',
        'country_name' => '',
        'interest' => 'Both',
        'seriousness' => 'Ready',
        'goal' => 'Integration test',
        'learn' => 'Yes',
        'score' => 'Hot',
        'source' => 'artisan-klaviyo-test',
        'timestamp' => now()->toISOString(),
    ]);

    if ($result['success'] ?? false) {
        $this->info($result['message'] ?? 'Klaviyo test sync succeeded.');
        $this->line('Profile ID: ' . ($result['profile_id'] ?? 'n/a'));
        $this->line('Subscription job ID: ' . ($result['subscription_job_id'] ?? 'n/a'));

        return 0;
    }

    $this->error($result['message'] ?? 'Klaviyo test sync failed.');

    return 1;
})->purpose('Send one explicit test profile to Klaviyo using the configured API key and list');
