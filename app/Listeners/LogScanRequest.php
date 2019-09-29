<?php

namespace App\Listeners;

use App\Events\ScanUpdateRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class LogScanRequest implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ScanUpdateRequest $event)
    {
        Log::info($event->scan->card_number);
    }
}
