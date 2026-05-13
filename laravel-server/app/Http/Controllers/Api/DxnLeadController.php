<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\BrevoLeadService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class DxnLeadController extends Controller
{
    public function store(Request $request, BrevoLeadService $brevo): JsonResponse
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

        if (! $brevo->createOrUpdateContact($data)) {
            return response()->json([
                'message' => 'Lead received, but Brevo sync failed. Please check server logs and Brevo configuration.',
            ], 502);
        }

        return response()->json([
            'message' => 'Lead synced to Brevo.',
            'score' => $data['score'],
        ]);
    }
}
