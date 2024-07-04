<?php

namespace Cboxdk\StatamicOverseer\Jobs;

use Cboxdk\StatamicOverseer\Facades\Overseer;
use Cboxdk\StatamicOverseer\Storage\SaveToDatabase;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PersistOverseerEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(public $events, public $audits, public $executionId, public $duration, public $memory, public $cpuUsage, public $user, public $impersonator)
    {
        $this->connection = config('statamic.overseer.storage.queue.connection');
        $this->queue = config('statamic.overseer.storage.queue.queue');
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Overseer::disableTracking();
        SaveToDatabase::sync($this->events, $this->audits, $this->executionId, $this->duration, $this->memory, $this->cpuUsage, $this->user, $this->impersonator);
    }
}
