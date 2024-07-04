<?php

namespace Cboxdk\StatamicOverseer\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class PersistOverseerEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $payload)
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        rescue(function () {
            $siteId = config('statamic.overseer.server.site');
            $url = config('statamic.overseer.server.endpoint')."/api/sites/{$siteId}/events";

            // Send events to overseer
            $response = Http::withToken(config('statamic.overseer.server.token'))
                ->post($url, $this->payload);
        });
    }
}
