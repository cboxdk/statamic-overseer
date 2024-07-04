# Overseer for Statamic

## Introduction

**Overseer for Statamic** is a powerful Statamic addon designed to collect audit and event data, allowing administrators to easily track who did what, when, and where within the system. With comprehensive logging capabilities and an intuitive user interface, Overseer ensures that every action and request is recorded, providing unparalleled visibility into your Statamic site's operations.

## Features

- **HTTP Requests Logging**: Track all incoming HTTP requests to your Statamic site.
- **SQL Queries Logging**: Monitor and log all SQL queries executed by your site.
- **Event Logging**: Capture critical events including:
    - Login and Logout activities
    - Creation, Update, and Deletion of entries
    - Changes to taxonomies, assets, blueprints, collections, and asset containers
    - Form submissions and form management actions
- **User Interface**: Easily view and search events through the Statamic control panel. The UI makes it simple to navigate and filter logs, providing a clear view of site activities.
- **Fieldtype Integration**: Seamlessly see changes in a single entry with a custom fieldtype.
- **Customizable Trackers**: Each tracker can be individually customized and configured. There is also the possibility to add more trackers or create your own.

## Data Storage

Overseer offers flexible data storage options to suit your needs:
- **SQLite**
- **MySQL**
- **PostgreSQL**
- Other compatible databases

Data collected by Overseer can also be sent to a cloud server for long-term storage and advanced analysis, helping identify abnormal traffic patterns and potential security threats. Please note that cloud server integration is currently in alpha and will be available in future releases.

## Installation

To install Overseer for Statamic, follow these steps:

1. Add the Overseer addon to your Statamic project using Composer:
```bash
composer require cboxdk/statamic-overseer
```

Add the Overseer addon to your Statamic project using Composer:

```bash
composer require cboxdk/statamic-overseer
```
Publish the addon configuration:

```bash
php artisan vendor:publish --tag=statamic-overseer-config
```

Configure the database connection to be used in the `config/statamic/overseer.php` file according to your preferred database system (SQLite, MySQL, PostgreSQL, etc.).  
Remember to configure your connection in the default `config/databases.php`

(Optional) Configure cloud server settings if you plan to use the cloud integration for long-term storage and analysis.

## Configuration Example
The configuration file (config/statamic-overseer.php) allows you to enable or disable Overseer, set storage options, and configure individual trackers:

```php
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
            'ignore_middlewares' => [
                'web',
            ],
        ],
        \Cboxdk\StatamicOverseer\Trackers\QueryTracker::class => [
            'ignore_connections' => ['sqlite'],
            'slow_query_time' => 100,
            'log_only_write' => true,
            'trace_max' => 20,
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
```

## Usage
Once installed and configured, Overseer will automatically start logging the specified events and requests.  
You can view and manage the logs through the Statamic control panel or by querying the database directly.  
The intuitive UI allows for easy searching and filtering of events, and the custom fieldtype provides a detailed view of changes in individual entries.

## Roadmap
* **Cloud Server Integration:** Full implementation for sending and storing data on a cloud server with advanced traffic analysis capabilities.
* **Dashboard Enhancements:** Improved UI for viewing and filtering logs within the Statamic control panel.
* **Additional Event Hooks:** Expanding the range of events and actions that can be logged.

## Contributing
We welcome contributions to improve Overseer for Statamic.  
If you encounter any issues or have suggestions for new features, please open an issue or submit a pull request on GitHub.