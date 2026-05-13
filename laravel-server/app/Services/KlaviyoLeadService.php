<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KlaviyoLeadService
{
    public function subscribeLead(array $lead): bool
    {
        $apiKey = $this->klaviyoConfig('api_key', 'KLAVIYO_PRIVATE_API_KEY');
        $listId = $this->normalizeListId($this->klaviyoConfig('list_id', 'KLAVIYO_LIST_ID'));

        if (empty($apiKey)) {
            Log::warning('Klaviyo lead sync skipped: missing KLAVIYO_PRIVATE_API_KEY');
            return false;
        }

        if (! $this->createOrUpdateProfile($lead)) {
            return false;
        }

        if (empty($listId)) {
            Log::warning('Klaviyo list subscription skipped: missing KLAVIYO_LIST_ID', [
                'email' => $lead['email'],
                'score' => $lead['score'],
            ]);

            return true;
        }

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
            $response = $this->klaviyoRequest()
                ->post($this->klaviyoUrl('/profile-subscription-bulk-create-jobs'), $payload);

            if ($response->status() !== 202) {
                Log::warning('Klaviyo lead sync failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'email' => $lead['email'],
                    'score' => $lead['score'],
                ]);

                return true;
            }
        } catch (\Throwable $e) {
            Log::warning('Klaviyo lead sync exception', [
                'message' => $e->getMessage(),
                'email' => $lead['email'],
                'score' => $lead['score'],
            ]);

            return true;
        }

        return true;
    }

    private function createOrUpdateProfile(array $lead): bool
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
            $response = $this->klaviyoRequest()
                ->post($this->klaviyoUrl('/profile-import'), $payload);

            if (! in_array($response->status(), [200, 201], true)) {
                Log::warning('Klaviyo profile import failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'email' => $lead['email'],
                    'score' => $lead['score'],
                ]);

                return false;
            }
        } catch (\Throwable $e) {
            Log::warning('Klaviyo profile import exception', [
                'message' => $e->getMessage(),
                'email' => $lead['email'],
                'score' => $lead['score'],
            ]);

            return false;
        }

        return true;
    }

    private function klaviyoRequest(): PendingRequest
    {
        return Http::timeout(10)
            ->asJson()
            ->withHeaders([
                'Accept' => 'application/vnd.api+json',
                'Authorization' => 'Klaviyo-API-Key ' . $this->klaviyoConfig('api_key', 'KLAVIYO_PRIVATE_API_KEY'),
                'Content-Type' => 'application/vnd.api+json',
                'revision' => $this->klaviyoConfig('revision', 'KLAVIYO_REVISION', '2026-04-15'),
            ]);
    }

    private function klaviyoUrl(string $path): string
    {
        $baseUrl = $this->klaviyoConfig('base_url', 'KLAVIYO_BASE_URL', 'https://a.klaviyo.com/api');

        return rtrim($baseUrl, '/') . $path;
    }

    private function klaviyoConfig(string $configKey, string $envKey, ?string $default = null): ?string
    {
        $value = config('services.klaviyo.' . $configKey) ?: env($envKey);

        if (! empty($value)) {
            return trim((string) $value);
        }

        return $this->envFileValue($envKey) ?? $default;
    }

    private function envFileValue(string $key): ?string
    {
        $envPath = base_path('.env');

        if (! is_readable($envPath)) {
            return null;
        }

        $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        foreach ($lines ?: [] as $line) {
            $line = trim($line);

            if ($line === '' || str_starts_with($line, '#') || ! str_contains($line, '=')) {
                continue;
            }

            [$lineKey, $value] = explode('=', $line, 2);

            if (trim($lineKey) !== $key) {
                continue;
            }

            $value = trim($value);

            if (
                (str_starts_with($value, '"') && str_ends_with($value, '"')) ||
                (str_starts_with($value, "'") && str_ends_with($value, "'"))
            ) {
                $value = substr($value, 1, -1);
            }

            return $value === '' ? null : $value;
        }

        return null;
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
}
