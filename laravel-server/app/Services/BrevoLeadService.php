<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BrevoLeadService
{
    public function createOrUpdateContact(array $lead): bool
    {
        $apiKey = config('services.brevo.api_key');

        if (empty($apiKey)) {
            Log::warning('Brevo lead sync skipped: missing BREVO_API_KEY');
            return false;
        }

        $payload = array_filter([
            'email' => $lead['email'],
            'attributes' => array_filter([
                'FIRSTNAME' => $this->firstName($lead['name']),
                'LASTNAME' => $this->lastName($lead['name']),
                'SMS' => $lead['whatsapp'],
                'WHATSAPP' => $lead['whatsapp'],
                'INTEREST' => $lead['interest'],
                'SERIOUSNESS' => $lead['seriousness'],
                'GOAL' => $lead['goal'],
                'LEARN' => $lead['learn'],
                'LEAD_SCORE' => $lead['score'],
                'SOURCE' => $lead['source'],
                'UTM_SOURCE' => $lead['utm_source'] ?? '',
                'UTM_MEDIUM' => $lead['utm_medium'] ?? '',
                'UTM_CAMPAIGN' => $lead['utm_campaign'] ?? '',
            ], fn ($value) => $value !== null && $value !== ''),
            'listIds' => $this->listIdsForScore($lead['score']),
            'updateEnabled' => true,
        ], fn ($value) => $value !== null && $value !== []);

        try {
            $response = Http::timeout(10)
                ->acceptJson()
                ->withHeaders([
                    'api-key' => $apiKey,
                ])
                ->post(rtrim(config('services.brevo.base_url'), '/') . '/contacts', $payload);

            if (! $response->successful()) {
                Log::warning('Brevo lead sync failed', [
                    'status' => $response->status(),
                    'body' => $response->body(),
                    'email' => $lead['email'],
                    'score' => $lead['score'],
                ]);

                return false;
            }
        } catch (\Throwable $e) {
            Log::warning('Brevo lead sync exception', [
                'message' => $e->getMessage(),
                'email' => $lead['email'],
                'score' => $lead['score'],
            ]);

            return false;
        }

        return true;
    }

    private function listIdsForScore(string $score): array
    {
        $ids = [
            config('services.brevo.default_list_id'),
            match ($score) {
                'Hot' => config('services.brevo.hot_list_id'),
                'Warm' => config('services.brevo.warm_list_id'),
                default => config('services.brevo.cold_list_id'),
            },
        ];

        return array_values(array_unique(array_filter(array_map(
            fn ($id) => is_numeric($id) ? (int) $id : null,
            $ids
        ))));
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
}
