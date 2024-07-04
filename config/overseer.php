<?php

return [
    'enabled' => env('OVERSEER_ENABLED', false),
    'storage' => [
        'enabled' => env('OVERSEER_STORAGE_ENABLED', true),
        'connection' => env('OVERSEER_STORAGE_CONNECTION', config('database.default')),
        'retention' => env('OVERSEER_STORAGE_RETENTION', 60),
        'queue' => env('OVERSEER_STORAGE_QUEUE', false),
    ],
    'server' => [
        'enabled' => env('OVERSEER_SERVER_ENABLED', false),
        'endpoint' => env('OVERSEER_SERVER_ENDPOINT', 'https://www.overseercloud.com'),
        'token' => env('OVERSEER_SERVER_TOKEN', null),
        'site' => env('OVERSEER_SERVER_SITE', null),
        'queue' => env('OVERSEER_SERVER_QUEUE', false),
    ],
    'trackers' => [
        \Cboxdk\StatamicOverseer\Trackers\RequestTracker::class => [
            'ignore_http_paths' => [
                '_debugbar/*',
            ],
            'ignore_http_methods' => [
                //            'get',
                //            'post',
                //            'put',
                //            'patch',
                //            'delete',
            ],
            'ignore_status_codes' => [
                //            '200',
            ],
            'ignore_middlewares' => [
                //'web',
            ],
        ],
        \Cboxdk\StatamicOverseer\Trackers\QueryTracker::class => [
            'ignore_connections' => ['sqlite'],
            'slow_query_time' => 100,
            'log_only_write' => true,
            'trace_max' => 20
        ],
        \Cboxdk\StatamicOverseer\Trackers\LogTracker::class => [],
        \Cboxdk\StatamicOverseer\Trackers\EventTracker::class => [
            'events' => [
                ...\Cboxdk\StatamicOverseer\Presets\EventPresets::all(),
            ],
        ],
    ],
    'query' => [
        'enabled' => env('OVERSEER_QUERY_ENABLED', true),
        'slow' => env('OVERSEER_QUERY_SLOW', 100),
        'ignore_connections' => [],
    ],

];
