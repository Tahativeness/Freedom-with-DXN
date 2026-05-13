<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\KlaviyoLeadService;
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
            'whatsapp' => ['required', 'string', 'max:40'],
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

        if (! $klaviyo->subscribeLead($data)) {
            return response()->json([
                'message' => 'Lead received, but Klaviyo sync failed. Please check server logs and Klaviyo configuration.',
            ], 502);
        }

        return response()->json([
            'message' => 'Lead synced to Klaviyo.',
            'score' => $data['score'],
        ]);
    }
}
