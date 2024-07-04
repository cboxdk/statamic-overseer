<?php

namespace Cboxdk\StatamicOverseer\Trackers;

abstract class Tracker
{
    /**
     * The configured watcher options.
     *
     * @var array
     */
    public $options = [];

    /**
     * Create a new watcher instance.
     *
     * @return void
     */
    public function __construct(array $options = [])
    {
        $this->options = $options;
    }

    /**
     * Register the watcher.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    abstract public function register($app);
}
