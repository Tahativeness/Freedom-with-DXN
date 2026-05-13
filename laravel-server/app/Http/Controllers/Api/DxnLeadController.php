<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\DxnLead;
use App\Services\KlaviyoLeadService;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DxnLeadController extends Controller
{
    public function store(Request $request, KlaviyoLeadService $klaviyo): JsonResponse
    {
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'whatsapp' => ['required', 'string', 'max:40', 'regex:/^\+\d{8,15}$/'],
            'country_code' => ['nullable', 'string', 'max:20'],
            'country_name' => ['nullable', 'string', 'max:100'],
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
        ]);

        $data['source'] = $data['source'] ?? 'freedomwithdxn.com';

        $lead = DxnLead::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'whatsapp' => $data['whatsapp'],
            'country_code' => $data['country_code'] ?? null,
            'country_name' => $data['country_name'] ?? null,
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
            'klaviyo_sync_status' => 'pending',
        ]);

        $klaviyoSynced = $klaviyo->subscribeLead($data);

        $lead->forceFill([
            'klaviyo_synced' => $klaviyoSynced,
            'klaviyo_sync_status' => $klaviyoSynced ? 'synced' : 'failed',
            'klaviyo_synced_at' => $klaviyoSynced ? now() : null,
            'klaviyo_error' => $klaviyoSynced ? null : 'Klaviyo sync failed. Lead was saved locally first.',
        ])->save();

        return response()->json([
            'message' => 'Thank you. Your submission has been received.',
            'lead_id' => $lead->id,
            'score' => $data['score'],
            'klaviyo_synced' => $klaviyoSynced,
        ]);
    }
}
