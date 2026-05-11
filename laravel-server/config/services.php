<?php

return [

    'meta' => [
        'pixel_id' => env('META_PIXEL_ID'),
        'access_token' => env('META_CONVERSIONS_API_TOKEN'),
        'test_event_code' => env('META_TEST_EVENT_CODE'),
        'graph_api_version' => env('META_GRAPH_API_VERSION', 'v18.0'),
    ],

    'brevo' => [
        'api_key' => env('BREVO_API_KEY'),
        'base_url' => env('BREVO_BASE_URL', 'https://api.brevo.com/v3'),
        'default_list_id' => env('BREVO_DEFAULT_LIST_ID'),
        'hot_list_id' => env('BREVO_HOT_LIST_ID'),
        'warm_list_id' => env('BREVO_WARM_LIST_ID'),
        'cold_list_id' => env('BREVO_COLD_LIST_ID'),
    ],

];
