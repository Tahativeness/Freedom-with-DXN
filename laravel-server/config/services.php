<?php

return [

    'meta' => [
        'pixel_id' => env('META_PIXEL_ID'),
        'access_token' => env('META_CONVERSIONS_API_TOKEN'),
        'test_event_code' => env('META_TEST_EVENT_CODE'),
        'graph_api_version' => env('META_GRAPH_API_VERSION', 'v18.0'),
    ],

];
