<?php

return [
    'private_api_key' => env('KLAVIYO_PRIVATE_API_KEY'),
    'company_id' => env('KLAVIYO_COMPANY_ID', 'Rks7DY'),
    'base_url' => env('KLAVIYO_BASE_URL', 'https://a.klaviyo.com/api'),
    'list_id' => env('KLAVIYO_LIST_ID'),
    'revision' => env('KLAVIYO_REVISION', '2026-04-15'),
    'timeout' => env('KLAVIYO_TIMEOUT', 15),
    'connect_timeout' => env('KLAVIYO_CONNECT_TIMEOUT', 5),
    'queue' => env('KLAVIYO_QUEUE', 'klaviyo'),
    'ca_bundle' => env('KLAVIYO_CA_BUNDLE'),
];
