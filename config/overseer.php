<?php

return [
    /*
    |--------------------------------------------------------------------------
    | enabled
    |--------------------------------------------------------------------------
    |
    | Enable or Disable all Overseer logging
    |
    */
    'enabled' => env('OVERSEER_ENABLED', false),

    /*
    |--------------------------------------------------------------------------
    | Storage
    |--------------------------------------------------------------------------
    |
    | Configure how you want to store you audit data locally.
    |
    */
    'storage' => [
        'enabled' => env('OVERSEER_STORAGE_ENABLED', true),
        'connection' => env('OVERSEER_STORAGE_CONNECTION', config('database.default')),
        'retention' => env('OVERSEER_STORAGE_RETENTION', 60),
        'queue' => [
            'enabled' => env('OVERSEER_STORAGE_QUEUE_ENABLED', false),
            'connection' => env('OVERSEER_STORAGE_QUEUE_CONNECTION', config('queue.default')),
            'queue' => env('OVERSEER_STORAGE_QUEUE_NAME', false),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Server
    |--------------------------------------------------------------------------
    |
    | Integrate with Overseer Cloud to offload your audit data.
    | Overseer Cloud includes analysis and notifications for abnormal traffic.
    |
    */
    'server' => [
        'enabled' => env('OVERSEER_SERVER_ENABLED', false),
        'endpoint' => env('OVERSEER_SERVER_ENDPOINT', 'https://www.overseercloud.com'),
        'token' => env('OVERSEER_SERVER_TOKEN', null),
        'site' => env('OVERSEER_SERVER_SITE', null),
        'queue' => env('OVERSEER_SERVER_QUEUE', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Trackers
    |--------------------------------------------------------------------------
    |
    | Configure the trackers here
    | Each tracker will monitor different aspects of your system.
    |
    */
    'trackers' => [
        \Cboxdk\StatamicOverseer\Trackers\RequestTracker::class => [
            'ignore_paths' => [
                '_debugbar/*',
                'cp/overseer/*',
                'cp/dashboard',
                'cp/updater/count',
                'up',
            ],
            'ignore_middlewares' => [
                'web',
            ],
            'hide_parameters' => [
                'password',
                'password_confirmation',
            ],
            'hide_headers' => [
                'authorization',
                'php-auth-pw',
            ],
        ],
        \Cboxdk\StatamicOverseer\Trackers\QueryTracker::class => [
            'ignore_connections' => ['sqlite'],
            'slow_query_time' => 100,
            'log_only_write' => true,
            'trace_max' => 20,
        ],
        \Cboxdk\StatamicOverseer\Trackers\HttpRequestTracker::class => [
            'hide_parameters' => [
                'password',
                'password_confirmation',
            ],
            'hide_headers' => [
                'authorization',
                'php-auth-pw',
            ],
        ],
        \Cboxdk\StatamicOverseer\Trackers\LogTracker::class => [],
        \Cboxdk\StatamicOverseer\Trackers\CommandTracker::class => [
            'ignore' => [
                'schedule:run',
                'schedule:finish',
                'package:discover',
                'queue:work',
                'queue:listen',
                'horizon',
                'horizon:supervisor',
                'horizon:work',
            ],
        ],
        \Cboxdk\StatamicOverseer\Trackers\JobTracker::class => [
            'ignore_jobs' => [
                \Cboxdk\StatamicOverseer\Jobs\PersistOverseerEvent::class,
                \Statamic\Search\UpdateItemIndexes::class,
            ],
        ],
        \Cboxdk\StatamicOverseer\Trackers\EventTracker::class => [
            'events' => [
                ...\Cboxdk\StatamicOverseer\Presets\EventPresets::all(),

            ],
        ],
    ],
];
