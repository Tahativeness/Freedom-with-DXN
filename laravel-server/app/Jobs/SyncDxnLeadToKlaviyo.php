<?php

namespace App\Jobs;

use App\Models\DxnLead;
use App\Services\KlaviyoLeadService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use RuntimeException;
use Throwable;

class SyncDxnLeadToKlaviyo implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public int $tries = 5;

    public int $timeout = 45;

    public function __construct(public int $leadId)
    {
    }

    public function backoff(): array
    {
        return [60, 300, 900, 1800];
    }

    public function handle(KlaviyoLeadService $klaviyo): void
    {
        $lead = DxnLead::find($this->leadId);

        if (! $lead) {
            Log::warning('Klaviyo sync job skipped because lead no longer exists', [
                'lead_id' => $this->leadId,
            ]);

            return;
        }

        if ($lead->klaviyo_sync_status === DxnLead::KLAVIYO_STATUS_SYNCED) {
            Log::info('Klaviyo sync job skipped because lead is already synced', [
                'lead_id' => $lead->id,
                'email' => $lead->email,
            ]);

            return;
        }

        $lead->forceFill([
            'klaviyo_sync_status' => DxnLead::KLAVIYO_STATUS_SYNCING,
            'klaviyo_retry_count' => (int) $lead->klaviyo_retry_count + 1,
            'klaviyo_last_attempted_at' => now(),
            'klaviyo_next_retry_at' => null,
        ])->save();

        $result = $klaviyo->syncLead($lead->klaviyoPayload());

        if ($result['success']) {
            $lead->forceFill([
                'klaviyo_synced' => true,
                'klaviyo_sync_status' => DxnLead::KLAVIYO_STATUS_SYNCED,
                'klaviyo_synced_at' => now(),
                'klaviyo_error' => null,
                'klaviyo_next_retry_at' => null,
                'klaviyo_profile_id' => $result['profile_id'] ?? $lead->klaviyo_profile_id,
                'klaviyo_subscription_job_id' => $result['subscription_job_id'] ?? $lead->klaviyo_subscription_job_id,
            ])->save();

            return;
        }

        $willRetry = ($result['retryable'] ?? false) && $this->attempts() < $this->tries;
        $nextRetryAt = $willRetry ? now()->addSeconds($this->backoffSeconds()) : null;

        $lead->forceFill([
            'klaviyo_synced' => false,
            'klaviyo_sync_status' => $willRetry ? DxnLead::KLAVIYO_STATUS_RETRYING : DxnLead::KLAVIYO_STATUS_FAILED,
            'klaviyo_error' => $this->truncateError($result['message'] ?? 'Klaviyo sync failed.'),
            'klaviyo_next_retry_at' => $nextRetryAt,
            'klaviyo_profile_id' => $result['profile_id'] ?? $lead->klaviyo_profile_id,
            'klaviyo_subscription_job_id' => $result['subscription_job_id'] ?? $lead->klaviyo_subscription_job_id,
        ])->save();

        if ($willRetry) {
            throw new RuntimeException($result['message'] ?? 'Retryable Klaviyo sync failure.');
        }
    }

    public function failed(?Throwable $exception): void
    {
        $lead = DxnLead::find($this->leadId);

        if (! $lead || $lead->klaviyo_sync_status === DxnLead::KLAVIYO_STATUS_SYNCED) {
            return;
        }

        $lead->forceFill([
            'klaviyo_synced' => false,
            'klaviyo_sync_status' => DxnLead::KLAVIYO_STATUS_FAILED,
            'klaviyo_error' => $this->truncateError($exception?->getMessage() ?? 'Klaviyo sync job failed.'),
            'klaviyo_next_retry_at' => null,
        ])->save();

        Log::error('Klaviyo sync job exhausted retries', [
            'lead_id' => $lead->id,
            'email' => $lead->email,
            'attempts' => $lead->klaviyo_retry_count,
            'error' => $exception?->getMessage(),
        ]);
    }

    private function backoffSeconds(): int
    {
        $backoff = $this->backoff();
        $index = max(0, min(count($backoff) - 1, $this->attempts() - 1));

        return $backoff[$index];
    }

    private function truncateError(string $message): string
    {
        return substr($message, 0, 60000);
    }
}
