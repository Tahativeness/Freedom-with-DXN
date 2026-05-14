<?php

namespace App\Services;

use Illuminate\Http\Client\ConnectionException;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KlaviyoLeadService
{
    private const PROFILE_IMPORT_ENDPOINT = '/profile-import';
    private const SUBSCRIPTION_ENDPOINT = '/profile-subscription-bulk-create-jobs';

    public function subscribeLead(array $lead): bool
    {
        return $this->syncLead($lead)['success'];
    }

    public function syncLead(array $lead): array
    {
        $lead = $this->normalizeLead($lead);
        $apiKey = $this->klaviyoConfig('api_key', 'KLAVIYO_PRIVATE_API_KEY');
        $listId = $this->normalizeListId($this->klaviyoConfig('list_id', 'KLAVIYO_LIST_ID'));

        if (empty($apiKey)) {
            return $this->failureResult('config', 'Missing KLAVIYO_PRIVATE_API_KEY.', false, $lead);
        }

        if (! str_starts_with($apiKey, 'pk_')) {
            return $this->failureResult('config', 'KLAVIYO_PRIVATE_API_KEY does not look like a private key.', false, $lead);
        }

        if (empty($listId)) {
            return $this->failureResult('config', 'Missing KLAVIYO_LIST_ID. Lead was not subscribed to a list.', false, $lead);
        }

        if (! $this->validListId($listId)) {
            return $this->failureResult('config', 'Invalid KLAVIYO_LIST_ID format. Use the short list ID or a Klaviyo list URL.', false, $lead, [
                'list_id_preview' => $this->previewValue($listId),
            ]);
        }

        $profileResult = $this->createOrUpdateProfile($lead);

        if (! $profileResult['success']) {
            return $profileResult;
        }

        $subscriptionResult = $this->subscribeProfileToList($lead, $listId);

        if (! $subscriptionResult['success']) {
            return array_merge($subscriptionResult, [
                'profile_id' => $profileResult['profile_id'] ?? null,
            ]);
        }

        return [
            'success' => true,
            'retryable' => false,
            'stage' => 'complete',
            'message' => 'Klaviyo profile imported and subscribed successfully.',
            'profile_id' => $profileResult['profile_id'] ?? null,
            'subscription_job_id' => $subscriptionResult['subscription_job_id'] ?? null,
            'profile_http_status' => $profileResult['http_status'] ?? null,
            'subscription_http_status' => $subscriptionResult['http_status'] ?? null,
        ];
    }

    private function createOrUpdateProfile(array $lead): array
    {
        $timestamp = $lead['timestamp'] ?? now()->toISOString();

        $attributes = [
            'email' => $lead['email'],
            'first_name' => $this->firstName($lead['name']),
            'last_name' => $this->lastName($lead['name']),
            'phone_number' => $this->phoneNumber($lead['whatsapp']),
            'properties' => array_filter([
                'Full Name' => $lead['name'],
                'WhatsApp' => $lead['whatsapp'],
                'WhatsApp Country Code' => $lead['country_code'] ?? null,
                'WhatsApp Country' => $lead['country_name'] ?? null,
                'Interest' => $lead['interest'],
                'Seriousness' => $lead['seriousness'],
                'Goal' => $lead['goal'],
                'Learn' => $lead['learn'],
                'Lead Score' => $lead['score'],
                'Lead Source' => $lead['source'],
                'Submitted At' => $timestamp,
                'UTM Source' => $lead['utm_source'] ?? null,
                'UTM Medium' => $lead['utm_medium'] ?? null,
                'UTM Campaign' => $lead['utm_campaign'] ?? null,
            ], fn ($value) => $value !== null && $value !== ''),
        ];

        $payload = [
            'data' => [
                'type' => 'profile',
                'attributes' => array_filter($attributes, fn ($value) => $value !== null && $value !== ''),
            ],
        ];

        try {
            $response = $this->postJsonApi(self::PROFILE_IMPORT_ENDPOINT, $payload);
        } catch (ConnectionException $e) {
            return $this->failureResult('profile_import', 'Klaviyo profile import connection failed: ' . $e->getMessage(), true, $lead);
        } catch (\Throwable $e) {
            return $this->failureResult('profile_import', 'Klaviyo profile import exception: ' . $e->getMessage(), true, $lead);
        }

        if (! in_array($response->status(), [200, 201], true)) {
            return $this->httpFailureResult('profile_import', 'Klaviyo profile import failed.', $response, $lead);
        }

        $profileId = Arr::get($response->json() ?? [], 'data.id');

        Log::info('Klaviyo profile import succeeded', [
            'email' => $lead['email'],
            'score' => $lead['score'],
            'status' => $response->status(),
            'profile_id' => $profileId,
        ]);

        return [
            'success' => true,
            'retryable' => false,
            'stage' => 'profile_import',
            'message' => $response->status() === 201 ? 'Klaviyo profile created.' : 'Klaviyo profile updated.',
            'profile_id' => $profileId,
            'http_status' => $response->status(),
        ];
    }

    private function subscribeProfileToList(array $lead, string $listId): array
    {
        $payload = [
            'data' => [
                'type' => 'profile-subscription-bulk-create-job',
                'attributes' => [
                    'custom_source' => $lead['source'],
                    'profiles' => [
                        'data' => [
                            [
                                'type' => 'profile',
                                'attributes' => [
                                    'email' => $lead['email'],
                                    'subscriptions' => [
                                        'email' => [
                                            'marketing' => [
                                                'consent' => 'SUBSCRIBED',
                                            ],
                                        ],
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'relationships' => [
                    'list' => [
                        'data' => [
                            'type' => 'list',
                            'id' => $listId,
                        ],
                    ],
                ],
            ],
        ];

        try {
            $response = $this->postJsonApi(self::SUBSCRIPTION_ENDPOINT, $payload);
        } catch (ConnectionException $e) {
            return $this->failureResult('list_subscription', 'Klaviyo list subscription connection failed: ' . $e->getMessage(), true, $lead, [
                'list_id_preview' => $this->previewValue($listId),
            ]);
        } catch (\Throwable $e) {
            return $this->failureResult('list_subscription', 'Klaviyo list subscription exception: ' . $e->getMessage(), true, $lead, [
                'list_id_preview' => $this->previewValue($listId),
            ]);
        }

        if ($response->status() !== 202) {
            return $this->httpFailureResult('list_subscription', 'Klaviyo list subscription failed.', $response, $lead, [
                'list_id_preview' => $this->previewValue($listId),
            ]);
        }

        $jobId = Arr::get($response->json() ?? [], 'data.id');

        Log::info('Klaviyo list subscription job accepted', [
            'email' => $lead['email'],
            'score' => $lead['score'],
            'status' => $response->status(),
            'subscription_job_id' => $jobId,
            'list_id_preview' => $this->previewValue($listId),
        ]);

        return [
            'success' => true,
            'retryable' => false,
            'stage' => 'list_subscription',
            'message' => 'Klaviyo list subscription job accepted.',
            'subscription_job_id' => $jobId,
            'http_status' => $response->status(),
        ];
    }

    private function httpFailureResult(string $stage, string $message, Response $response, array $lead, array $context = []): array
    {
        $status = $response->status();
        $errorDetail = $this->klaviyoErrorMessage($response);
        $retryable = $status === 429 || $status >= 500;
        $reason = trim($message . ' HTTP ' . $status . ($errorDetail ? ': ' . $errorDetail : ''));

        return $this->failureResult($stage, $reason, $retryable, $lead, array_merge($context, [
            'status' => $status,
            'body' => $this->truncatedBody($response),
            'retryable' => $retryable,
        ]));
    }

    private function failureResult(string $stage, string $message, bool $retryable, array $lead, array $context = []): array
    {
        Log::warning('Klaviyo lead sync failed', array_merge([
            'stage' => $stage,
            'email' => $lead['email'] ?? null,
            'score' => $lead['score'] ?? null,
            'retryable' => $retryable,
            'message' => $message,
        ], $context));

        return [
            'success' => false,
            'retryable' => $retryable,
            'stage' => $stage,
            'message' => $message,
            'profile_id' => null,
            'subscription_job_id' => null,
        ];
    }

    private function klaviyoRequest(): PendingRequest
    {
        return Http::timeout((int) $this->klaviyoConfig('timeout', 'KLAVIYO_TIMEOUT', '15'))
            ->connectTimeout((int) $this->klaviyoConfig('connect_timeout', 'KLAVIYO_CONNECT_TIMEOUT', '5'))
            ->withOptions($this->requestOptions())
            ->withHeaders([
                'Accept' => 'application/vnd.api+json',
                'Authorization' => 'Klaviyo-API-Key ' . $this->klaviyoConfig('api_key', 'KLAVIYO_PRIVATE_API_KEY'),
                'revision' => $this->klaviyoConfig('revision', 'KLAVIYO_REVISION', '2026-04-15'),
            ]);
    }

    private function postJsonApi(string $endpoint, array $payload): Response
    {
        return $this->klaviyoRequest()
            ->withBody(json_encode($payload, JSON_THROW_ON_ERROR), 'application/vnd.api+json')
            ->post($this->klaviyoUrl($endpoint));
    }

    private function requestOptions(): array
    {
        $caBundle = $this->klaviyoConfig('ca_bundle', 'KLAVIYO_CA_BUNDLE');

        if (empty($caBundle)) {
            return [];
        }

        $path = $caBundle;

        if (! preg_match('/^(?:[A-Za-z]:[\\\\\\/]|\\\\\\\\|\\/)/', $path)) {
            $path = base_path($path);
        }

        return file_exists($path) ? ['verify' => $path] : [];
    }

    private function klaviyoUrl(string $path): string
    {
        $baseUrl = $this->klaviyoConfig('base_url', 'KLAVIYO_BASE_URL', 'https://a.klaviyo.com/api');

        return rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
    }

    private function klaviyoConfig(string $configKey, string $envKey, ?string $default = null): ?string
    {
        $value = config('services.klaviyo.' . $configKey) ?: env($envKey, $default);

        return empty($value) ? $default : trim((string) $value);
    }

    private function normalizeLead(array $lead): array
    {
        $lead['name'] = trim((string) ($lead['name'] ?? ''));
        $lead['email'] = strtolower(trim((string) ($lead['email'] ?? '')));
        $lead['whatsapp'] = $this->phoneNumber((string) ($lead['whatsapp'] ?? '')) ?? trim((string) ($lead['whatsapp'] ?? ''));
        $lead['source'] = trim((string) ($lead['source'] ?? 'freedomwithdxn.com'));
        $lead['score'] = trim((string) ($lead['score'] ?? ''));

        return $lead;
    }

    private function klaviyoErrorMessage(Response $response): ?string
    {
        $json = $response->json();
        $errors = is_array($json) ? Arr::get($json, 'errors', []) : [];

        if (! is_array($errors) || $errors === []) {
            return null;
        }

        $messages = [];

        foreach (array_slice($errors, 0, 3) as $error) {
            if (! is_array($error)) {
                continue;
            }

            $messages[] = trim(implode(' ', array_filter([
                Arr::get($error, 'code'),
                Arr::get($error, 'title'),
                Arr::get($error, 'detail'),
            ])));
        }

        return $messages === [] ? null : implode(' | ', $messages);
    }

    private function truncatedBody(Response $response): string
    {
        return substr($response->body(), 0, 2000);
    }

    private function firstName(string $name): string
    {
        $parts = preg_split('/\s+/', trim($name), 2);

        return $parts[0] ?? $name;
    }

    private function lastName(string $name): ?string
    {
        $parts = preg_split('/\s+/', trim($name), 2);

        return $parts[1] ?? null;
    }

    private function phoneNumber(string $phone): ?string
    {
        $phone = preg_replace('/[^\d+]/', '', trim($phone));

        if (! is_string($phone) || ! preg_match('/^\+\d{8,15}$/', $phone)) {
            return null;
        }

        return $phone;
    }

    private function normalizeListId(?string $listId): ?string
    {
        if (empty($listId)) {
            return null;
        }

        $listId = trim($listId);
        $path = parse_url($listId, PHP_URL_PATH);

        if (is_string($path) && preg_match('#/list/([^/]+)#', $path, $matches)) {
            return $matches[1];
        }

        return $listId;
    }

    private function validListId(string $listId): bool
    {
        return (bool) preg_match('/^[A-Za-z0-9_-]{3,64}$/', $listId);
    }

    private function previewValue(string $value): string
    {
        if (strlen($value) <= 8) {
            return $value;
        }

        return substr($value, 0, 4) . '...' . substr($value, -4);
    }
}
