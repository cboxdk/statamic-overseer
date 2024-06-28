<?php

namespace Cboxdk\StatamicOverseer;

use Statamic\Providers\AddonServiceProvider;

class ServiceProvider extends AddonServiceProvider
{
    protected $filters = [
        Filters\StatamicOverseerFilter::class,
    ];
    protected $actions = [
        Actions\StatamicOverseer::class,
    ];
    protected $widgets = [
        Widgets\StatamicOverseer::class,
    ];
    protected $tags = [
        Tags\StatamicOverseer::class,
    ];
    protected $modifiers = [
        Modifiers\StatamicOverseer::class,
    ];
    protected $scopes = [
        Scopes\StatamicOverseer::class,
    ];
    protected $fieldtypes = [
        Fieldtypes\StatamicOverseer::class,
    ];
    protected $vite = [
        'input' => [
            'resources/js/addon.js',
        ],
        'publicDirectory' => 'resources/dist',
    ];
    public function bootAddon()
    {
        //
    }
}
