<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;

class KlaviyoController extends Controller
{
    public function status(): JsonResponse
    {
        $apiKey = config('klaviyo.private_api_key') ?: config('services.klaviyo.api_key');
        $listId = config('klaviyo.list_id') ?: config('services.klaviyo.list_id');
        $companyId = config('klaviyo.company_id') ?: config('services.klaviyo.company_id');

        return response()->json([
            'klaviyo_private_api_key_loaded' => filled($apiKey),
            'klaviyo_company_id_loaded' => filled($companyId),
            'klaviyo_list_id_loaded' => filled($listId),
            'queue_connection' => config('queue.default'),
            'klaviyo_queue' => config('klaviyo.queue') ?: config('services.klaviyo.queue'),
        ]);
    }
}
