<?php

namespace App\Listeners;

use App\Events\ScanCreated;
use App\Events\ScanUpdateRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateScanControl
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
     * @param ScanCreated $event
     * @return void
     */
    public function handle(ScanUpdateRequest $event)
    {
        // TODO
        $scan = $event->scan;
        $scan->committee_member = (rand(0, 100) >= 50);
        $scan->save();
    }
}
