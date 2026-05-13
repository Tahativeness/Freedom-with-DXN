<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KlaviyoLeadService
{
    public function subscribeLead(array $lead): bool
    {
        $apiKey = config('services.klaviyo.api_key');
        $listId = $this->normalizeListId(config('services.klaviyo.list_id'));

        if (empty($apiKey) || empty($listId)) {
            Log::warning('Klaviyo lead sync skipped: missing KLAVIYO_PRIVATE_API_KEY or KLAVIYO_LIST_ID');
            return false;
        }

        if (! $this->createOrUpdateProfile($lead)) {
            return false;
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
                                    'phone_number' => $lead['whatsapp'],
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
                ->post(rtrim(config('services.klaviyo.base_url'), '/') . '/profile-subscription-bulk-create-jobs', $payload);

            if ($response->status() !== 202) {
                Log::warning('Klaviyo lead sync failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'email' => $lead['email'],
                    'score' => $lead['score'],
                ]);

                return false;
            }
        } catch (\Throwable $e) {
            Log::warning('Klaviyo lead sync exception', [
                'message' => $e->getMessage(),
                'email' => $lead['email'],
                'score' => $lead['score'],
            ]);

            return false;
        }

        return true;
    }

    private function createOrUpdateProfile(array $lead): bool
    {
        $timestamp = $lead['timestamp'] ?? now()->toISOString();

        $payload = [
            'data' => [
                'type' => 'profile',
                'attributes' => [
                    'email' => $lead['email'],
                    'phone_number' => $lead['whatsapp'],
                    'first_name' => $this->firstName($lead['name']),
                    'last_name' => $this->lastName($lead['name']),
                    'properties' => array_filter([
                        'Full Name' => $lead['name'],
                        'WhatsApp' => $lead['whatsapp'],
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
                ],
            ],
        ];

        try {
            $response = $this->klaviyoRequest()
                ->post(rtrim(config('services.klaviyo.base_url'), '/') . '/profile-import', $payload);

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
                'Authorization' => 'Klaviyo-API-Key ' . config('services.klaviyo.api_key'),
                'Content-Type' => 'application/vnd.api+json',
                'revision' => config('services.klaviyo.revision'),
            ]);
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
