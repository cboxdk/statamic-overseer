<?php

use Illuminate\Support\Facades\Event;

uses(\Cboxdk\StatamicOverseer\Tests\TestCase::class);

use Statamic\Auth\File\User;

test('login event', function () {

    $user = new User;
    $user->email = 'test@example.com';
    $user->name = 'Test User';
    $user->save();

    Auth::login($user);

    // Test events
    $events = collect(\Cboxdk\StatamicOverseer\Facades\Overseer::getEvents())->filter(function(\Cboxdk\StatamicOverseer\Event $event) {
        if (isset($event->content['event']) && $event->content['event'] == 'Illuminate\Auth\Events\Login') {
            return $event;
        }
    })->values();

    $this->assertCount(1, $events);

});
