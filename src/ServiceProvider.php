<?php

namespace Cboxdk\StatamicOverseer;

use Cboxdk\StatamicOverseer\Models\OverseerAudit;
use Cboxdk\StatamicOverseer\Models\OverseerEvent;
use Cboxdk\StatamicOverseer\Models\OverseerExecution;
use Cboxdk\StatamicOverseer\Policies\OverseerAuditPolicy;
use Cboxdk\StatamicOverseer\Policies\OverseerEventPolicy;
use Cboxdk\StatamicOverseer\Policies\OverseerExecutionPolicy;
use Statamic\Facades\CP\Nav;
use Statamic\Facades\Permission;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $routes = [
        'cp' => __DIR__.'/../routes/cp.php',
    ];

    protected $policies = [
        OverseerAudit::class => OverseerAuditPolicy::class,
        OverseerEvent::class => OverseerEventPolicy::class,
        OverseerExecution::class => OverseerExecutionPolicy::class,
    ];

    protected $scopes = [
        Scopes\OverseerDate::class,
    ];

    protected $vite = [
        'input' => [
            'resources/js/addon.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];

    public function boot(): void
    {
        parent::boot();
        $this->mergeConfigFrom($config = __DIR__.'/../config/overseer.php', 'statamic.overseer');
        $this->publishes([$config => config_path('statamic/overseer.php')], 'statamic-overseer-config');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        // don't register watchers if not enabled
        if (! config('statamic.overseer.enabled')) {
            return;
        }

        foreach (config('statamic.overseer.trackers', []) as $key => $tracker) {
            if (is_string($key) && $tracker === false) {
                continue;
            }

            if (is_array($tracker) && ! ($tracker['enabled'] ?? true)) {
                continue;
            }

            $tracker = $this->app->make(is_string($key) ? $key : $tracker, [
                'options' => is_array($tracker) ? $tracker : [],
            ]);

            Overseer::$trackers[] = get_class($tracker);

            $tracker->register($this->app);
        }

        \Cboxdk\StatamicOverseer\Facades\Overseer::start($this->app);

        // Add terminating callback
        $this->app->terminating(function () {
            \Cboxdk\StatamicOverseer\Facades\Overseer::store();
        });
    }

    public function bootAddon()
    {
        $this->bootPermissions();
        $this->app->bind('Overseer', function () {
            return new Overseer();
        });

        Nav::extend(function ($nav) {
            $nav->create('Audits')
                ->section('Overseer')
                ->can('access overseer')
                ->route('overseer.audits.index')
                ->icon('content-writing');
            $nav->create('Events')
                ->section('Overseer')
                ->can('access overseer')
                ->route('overseer.events.index')
                ->icon('time');
            $nav->create('Executions')
                ->section('Overseer')
                ->can('access overseer')
                ->route('overseer.executions.index')
                ->icon('array');
        });
    }

    protected function bootPermissions(): self
    {
        Permission::group('overseer', 'Overseer', function () {
            Permission::register('access overseer', function ($permission) {
                $permission
                    ->label('Access to overseer data')
                    ->description('Grants access to view audits, events and executions');
            });
        });

        return $this;
    }
}
