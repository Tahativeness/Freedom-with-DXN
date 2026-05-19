<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\SyncDxnLeadToKlaviyo;
use App\Models\DxnLead;
use Illuminate\Database\QueryException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class DxnLeadController extends Controller
{
    public function store(Request $request): JsonResponse
    {
        $input = $this->sanitizeInput($request->all());

        if ($this->isBotSubmission($input, $request)) {
            return $this->acceptedResponse(null, 'queued');
        }

        try {
            $data = Validator::make($input, $this->rules())->validate();
            $this->ensureCountryCodeMatchesPhone($data);
        } catch (ValidationException $e) {
            Log::notice('DXN lead validation failed', [
                'ip' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
                'errors' => $e->errors(),
            ]);

            throw $e;
        }

        $existingLead = $this->findExistingSubmission($data);

        if ($existingLead) {
            if (! $existingLead->klaviyo_synced) {
                Log::info('DXN duplicate lead submission found; retrying Klaviyo sync', [
                    'lead_id' => $existingLead->id,
                    'email' => $existingLead->email,
                    'status' => $existingLead->klaviyo_sync_status,
                    'has_idempotency_key' => ! empty($data['idempotency_key'] ?? null),
                ]);

                $this->queueKlaviyoSync($existingLead);
                $existingLead->refresh();

                return $this->acceptedResponse($existingLead, $existingLead->klaviyo_sync_status);
            }

            Log::info('DXN duplicate lead submission ignored because Klaviyo is already synced', [
                'lead_id' => $existingLead->id,
                'email' => $existingLead->email,
                'status' => $existingLead->klaviyo_sync_status,
                'has_idempotency_key' => ! empty($data['idempotency_key'] ?? null),
            ]);

            return $this->acceptedResponse($existingLead, $existingLead->klaviyo_sync_status);
        }

        $data['source'] = $data['source'] ?? 'freedomwithdxn.com';

        try {
            $lead = DxnLead::create([
                'name' => $data['name'],
                'email' => $data['email'],
                'whatsapp' => $data['whatsapp'],
                'country_code' => $data['country_code'],
                'country_name' => $data['country_name'] ?? null,
                'address' => $data['address'] ?? null,
                'interest' => $data['interest'],
                'seriousness' => $data['seriousness'],
                'goal' => $data['goal'],
                'learn' => $data['learn'],
                'score' => $data['score'],
                'source' => $data['source'],
                'submitted_at' => isset($data['timestamp']) ? Carbon::parse($data['timestamp']) : now(),
                'utm_source' => $data['utm_source'] ?? null,
                'utm_medium' => $data['utm_medium'] ?? null,
                'utm_campaign' => $data['utm_campaign'] ?? null,
                'payload' => $data,
                'idempotency_key' => $data['idempotency_key'] ?? null,
                'klaviyo_sync_status' => DxnLead::KLAVIYO_STATUS_PENDING,
            ]);
        } catch (QueryException $e) {
            $lead = $this->findExistingSubmission($data);

            if (! $lead) {
                throw $e;
            }

            return $this->acceptedResponse($lead, $lead->klaviyo_sync_status);
        }

        $this->queueKlaviyoSync($lead);
        $lead->refresh();

        return $this->acceptedResponse($lead, $lead->klaviyo_sync_status);
    }

    private function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:255'],
            'email' => ['required', 'email:rfc', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:40', 'regex:/^\+\d{8,15}$/'],
            'country_code' => ['required', 'string', 'max:20', 'regex:/^\+\d{1,4}$/'],
            'country_name' => ['nullable', 'string', 'max:100'],
            'address' => ['nullable', 'string', 'max:255'],
            'interest' => ['required', Rule::in(['Health', 'Income', 'Both'])],
            'seriousness' => ['required', Rule::in(['Exploring', 'SideIncome', 'Ready'])],
            'goal' => ['required', 'string', 'max:255'],
            'learn' => ['required', Rule::in(['Yes', 'Maybe', 'No'])],
            'score' => ['required', Rule::in(['Hot', 'Warm', 'Cold'])],
            'source' => ['nullable', 'string', 'max:255'],
            'timestamp' => ['nullable', 'date'],
            'utm_source' => ['nullable', 'string', 'max:255'],
            'utm_medium' => ['nullable', 'string', 'max:255'],
            'utm_campaign' => ['nullable', 'string', 'max:255'],
            'idempotency_key' => ['nullable', 'string', 'max:120'],
            'form_started_at' => ['nullable', 'numeric'],
            'company_website' => ['nullable', 'string', 'max:0'],
        ];
    }

    private function sanitizeInput(array $input): array
    {
        foreach ([
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
            'utm_source',
            'utm_medium',
            'utm_campaign',
            'idempotency_key',
            'company_website',
        ] as $field) {
            if (array_key_exists($field, $input) && is_scalar($input[$field])) {
                $input[$field] = trim(strip_tags((string) $input[$field]));
            }
        }

        if (! empty($input['email'])) {
            $input['email'] = strtolower($input['email']);
        }

        if (! empty($input['whatsapp'])) {
            $digits = preg_replace('/\D/', '', (string) $input['whatsapp']);
            $input['whatsapp'] = $digits ? '+' . $digits : '';
        }

        if (! empty($input['country_code'])) {
            $digits = preg_replace('/\D/', '', (string) $input['country_code']);
            $input['country_code'] = $digits ? '+' . $digits : '';
        }

        return $input;
    }

    private function isBotSubmission(array $input, Request $request): bool
    {
        if (! empty($input['company_website'] ?? null)) {
            Log::notice('DXN lead honeypot triggered', [
                'ip' => $request->ip(),
                'user_agent' => substr((string) $request->userAgent(), 0, 255),
            ]);

            return true;
        }

        $startedAt = isset($input['form_started_at']) ? (float) $input['form_started_at'] : null;

        if ($startedAt && $startedAt > 0) {
            $elapsedMs = floor(microtime(true) * 1000) - $startedAt;

            if ($elapsedMs >= 0 && $elapsedMs < 1500) {
                Log::notice('DXN lead rejected as too-fast submission', [
                    'ip' => $request->ip(),
                    'elapsed_ms' => (int) $elapsedMs,
                    'user_agent' => substr((string) $request->userAgent(), 0, 255),
                ]);

                return true;
            }
        }

        return false;
    }

    private function ensureCountryCodeMatchesPhone(array $data): void
    {
        if (! str_starts_with($data['whatsapp'], $data['country_code'])) {
            throw ValidationException::withMessages([
                'whatsapp' => 'The WhatsApp number must match the selected country code.',
            ]);
        }
    }

    private function findExistingSubmission(array $data): ?DxnLead
    {
        if (! empty($data['idempotency_key'] ?? null)) {
            $lead = DxnLead::where('idempotency_key', $data['idempotency_key'])->first();

            if ($lead) {
                return $lead;
            }
        }

        return DxnLead::query()
            ->where('email', $data['email'])
            ->where('whatsapp', $data['whatsapp'])
            ->where('created_at', '>=', now()->subMinutes(10))
            ->latest()
            ->first();
    }

    private function queueKlaviyoSync(DxnLead $lead): void
    {
        try {
            $lead->forceFill([
                'klaviyo_sync_status' => DxnLead::KLAVIYO_STATUS_QUEUED,
                'klaviyo_error' => null,
            ])->save();

            SyncDxnLeadToKlaviyo::dispatch($lead->id)
                ->onQueue(config('services.klaviyo.queue', 'klaviyo'));
        } catch (Throwable $e) {
            $lead->forceFill([
                'klaviyo_synced' => false,
                'klaviyo_sync_status' => DxnLead::KLAVIYO_STATUS_FAILED,
                'klaviyo_error' => 'Unable to queue Klaviyo sync job: ' . $e->getMessage(),
            ])->save();

            Log::error('Unable to queue Klaviyo sync job', [
                'lead_id' => $lead->id,
                'email' => $lead->email,
                'error' => $e->getMessage(),
            ]);
        }
    }

    private function acceptedResponse(?DxnLead $lead, string $syncStatus): JsonResponse
    {
        return response()->json([
            'message' => 'Thank you. Your submission has been received.',
            'lead_id' => $lead?->id,
            'score' => $lead?->score,
            'klaviyo_sync_status' => $syncStatus,
            'klaviyo_synced' => (bool) ($lead?->klaviyo_synced ?? false),
        ], 202);
    }
}
