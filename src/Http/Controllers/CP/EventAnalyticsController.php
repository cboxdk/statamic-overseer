<?php

namespace Cboxdk\StatamicOverseer\Http\Controllers\CP;

use Carbon\Carbon;
use Cboxdk\StatamicOverseer\Models\OverseerEvent;
use Flowframe\Trend\Trend;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Statamic\Http\Controllers\CP\CpController;

class EventAnalyticsController extends CpController
{
    public function index(Request $request)
    {
        $requests = Trend::query(OverseerEvent::query()->where('type', 'request'))
            ->dateColumn('recorded_at')
            ->between(
                start: now()->subHours(1)->addMinute(),
                end: now(),
            )
            ->perMinute()
            ->count();
        $commands = Trend::query(OverseerEvent::query()->where('type', 'command'))
            ->dateColumn('recorded_at')
            ->between(
                start: now()->subHours(1)->addMinute(),
                end: now(),
            )
            ->perMinute()
            ->count();
        $jobs = Trend::query(OverseerEvent::query()->where('type', 'jobs'))
            ->dateColumn('recorded_at')
            ->between(
                start: now()->subHours(1)->addMinute(),
                end: now(),
            )
            ->perMinute()
            ->count();

        return new JsonResponse([
            'labels' => $requests->pluck('date')->map(fn ($date) => Carbon::make($date)->format('H:i')),
            'requests' => $requests->pluck('aggregate'),
            'commands' => $commands->pluck('aggregate'),
            'jobs' => $jobs->pluck('aggregate'),
        ]);

    }
}
