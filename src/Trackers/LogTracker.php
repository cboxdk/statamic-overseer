<?php

namespace Cboxdk\StatamicOverseer\Trackers;

use Cboxdk\StatamicOverseer\Event;
use Cboxdk\StatamicOverseer\Facades\Overseer;
use Illuminate\Foundation\Http\Events\RequestHandled;
use Illuminate\Log\Events\MessageLogged;
use Illuminate\Support\Facades\Session;
use Statamic\Support\Arr;
use Statamic\Support\Str;
use Psr\Log\LogLevel;

class LogTracker extends Tracker
{

    /**
     * The available log level priorities.
     */
    private const PRIORITIES = [
        LogLevel::DEBUG => 100,
        LogLevel::INFO => 200,
        LogLevel::NOTICE => 250,
        LogLevel::WARNING => 300,
        LogLevel::ERROR => 400,
        LogLevel::CRITICAL => 500,
        LogLevel::ALERT => 550,
        LogLevel::EMERGENCY => 600,
    ];


    public function register($app)
    {
        $app['events']->listen(MessageLogged::class, [$this, 'recordLog']);
    }

    public function recordLog(MessageLogged $event)
    {
        if (! Overseer::isTracking()) {
            return;
        }


        $log = new Event('log',[
            'level' => $event->level,
            'message' => (string) $event->message,
            'context' => Arr::except($event->context, []),
        ]);
        Overseer::trackEvent($log);


    }
}
