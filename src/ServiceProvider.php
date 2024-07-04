<?php

namespace Cboxdk\StatamicOverseer;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    public function boot(): void
    {
        parent::boot();
        $this->mergeConfigFrom($config = __DIR__.'/../config/overseer.php', 'statamic.overseer');
        $this->publishes([$config => config_path('statamic/overseer.php')], 'statamic-overseer-config');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

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
        $this->app->bind('Overseer', function () {
            return new Overseer();
        });
    }
}
