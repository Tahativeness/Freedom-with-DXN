<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class MetaConversionsApi
{
    public function send(
        string $eventName,
        array $customData = [],
        array $userData = [],
        ?string $eventId = null,
        ?Request $request = null
    ): ?string {
        $pixelId = config('services.meta.pixel_id');
        $token   = config('services.meta.access_token');

        if (empty($pixelId) || empty($token)) {
            return null;
        }

        $request = $request ?? request();
        $eventId = $eventId ?: (string) Str::uuid();

        $payload = [
            'data' => [[
                'event_name'       => $eventName,
                'event_time'       => time(),
                'event_id'         => $eventId,
                'event_source_url' => $request->fullUrl(),
                'action_source'    => 'website',
                'user_data'        => array_filter(array_merge(
                    $this->autoUserData($request),
                    $userData
                ), fn($v) => $v !== null && $v !== '' && $v !== []),
                'custom_data'      => $customData,
            ]],
        ];

        $testCode = config('services.meta.test_event_code');
        if (! empty($testCode)) {
            $payload['test_event_code'] = $testCode;
        }

        $version = config('services.meta.graph_api_version', 'v18.0');
        $url     = "https://graph.facebook.com/{$version}/{$pixelId}/events";

        try {
            $response = Http::timeout(5)
                ->withQueryParameters(['access_token' => $token])
                ->post($url, $payload);

            if (! $response->successful()) {
                Log::warning('Meta Conversions API non-2xx', [
                    'event'  => $eventName,
                    'status' => $response->status(),
                    'body'   => $response->body(),
                ]);
                return null;
            }
        } catch (\Throwable $e) {
            Log::warning('Meta Conversions API exception', [
                'event'   => $eventName,
                'message' => $e->getMessage(),
            ]);
            return null;
        }

        return $eventId;
    }

    public function hash(?string $value): ?string
    {
        if ($value === null) return null;
        $value = strtolower(trim($value));
        return $value === '' ? null : hash('sha256', $value);
    }

    public function hashPhone(?string $phone): ?string
    {
        if (empty($phone)) return null;
        $digits = preg_replace('/[^0-9]/', '', $phone);
        return $digits === '' ? null : hash('sha256', $digits);
    }

    private function autoUserData(Request $request): array
    {
        $data = [
            'client_ip_address' => $request->ip(),
            'client_user_agent' => $request->userAgent() ?: '',
            'fbp' => $request->cookie('_fbp'),
            'fbc' => $request->cookie('_fbc'),
        ];

        $user = auth()->user();
        if ($user) {
            if (! empty($user->email)) {
                $data['em'] = [$this->hash($user->email)];
            }
            if (! empty($user->phone)) {
                $data['ph'] = [$this->hashPhone($user->phone)];
            }
            if (! empty($user->name)) {
                $parts = preg_split('/\s+/', trim($user->name), 2);
                if (! empty($parts[0])) $data['fn'] = [$this->hash($parts[0])];
                if (! empty($parts[1])) $data['ln'] = [$this->hash($parts[1])];
            }
            $data['external_id'] = [hash('sha256', (string) $user->id)];
        }

        return $data;
    }
}
