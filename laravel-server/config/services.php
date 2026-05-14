<?php

return [

    'meta' => [
        'pixel_id' => env('META_PIXEL_ID'),
        'access_token' => env('META_CONVERSIONS_API_TOKEN'),
        'test_event_code' => env('META_TEST_EVENT_CODE'),
        'graph_api_version' => env('META_GRAPH_API_VERSION', 'v18.0'),
    ],

    'klaviyo' => [
        'api_key' => env('KLAVIYO_PRIVATE_API_KEY'),
        'base_url' => env('KLAVIYO_BASE_URL', 'https://a.klaviyo.com/api'),
        'list_id' => env('KLAVIYO_LIST_ID'),
        'revision' => env('KLAVIYO_REVISION', '2026-04-15'),
        'timeout' => env('KLAVIYO_TIMEOUT', 15),
        'connect_timeout' => env('KLAVIYO_CONNECT_TIMEOUT', 5),
        'queue' => env('KLAVIYO_QUEUE', 'klaviyo'),
        'ca_bundle' => env('KLAVIYO_CA_BUNDLE'),
    ],

];
