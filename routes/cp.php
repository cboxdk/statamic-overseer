<?php

use Cboxdk\StatamicOverseer\Http\Controllers\CP\AuditsController;
use Cboxdk\StatamicOverseer\Http\Controllers\CP\EventAnalyticsController;
use Cboxdk\StatamicOverseer\Http\Controllers\CP\EventsController;
use Cboxdk\StatamicOverseer\Http\Controllers\CP\ExecutionsController;

Route::middleware('statamic.cp.authenticated')
    ->name('overseer.')
    ->prefix('overseer')
    ->group(function () {
        Route::get('executions/list', [ExecutionsController::class, 'list']);
        Route::resource('executions', ExecutionsController::class)->only(['index', 'show']);
        Route::get('events/list', [EventsController::class, 'list']);
        Route::get('events/analytics', [EventAnalyticsController::class, 'index']);
        Route::resource('events', EventsController::class)->only(['index']);
        Route::get('audits/list', [AuditsController::class, 'list']);
        Route::resource('audits', AuditsController::class)->only(['index']);
    });
