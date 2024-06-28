<?php

namespace Cboxdk\StatamicOverseer;

use Cboxdk\StatamicOverseer\Subscribers\OverseerEventSubscriber;
use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{

    protected $subscribe = [
        OverseerEventSubscriber::class,
    ];
    protected $widgets = [
        //Widgets\StatamicOverseer::class,
    ];

    protected $fieldtypes = [
        //Fieldtypes\StatamicOverseer::class,
    ];
//    protected $vite = [
//        'input' => [
//            'resources/js/addon.js',
//        ],
//        'publicDirectory' => 'resources/dist',
//    ];

    public function boot(): void
    {
        parent::boot();

        $this->mergeConfigFrom($config = __DIR__.'/../config/overseer.php', 'statamic.overseer');

        if (! $this->app->runningInConsole()) {
            return;
        }

        $this->publishes([$config => config_path('statamic/overseer.php')], 'statamic-overseer-config');

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

    }

    public function bootAddon()
    {
        $this->app->bind('Overseer', function () {
            return new Overseer();
        });
    }
}
