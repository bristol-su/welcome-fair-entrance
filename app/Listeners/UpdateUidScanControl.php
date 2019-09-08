<?php

namespace App\Listeners;

use App\Events\ScanCreated;
use App\Events\UidScanUpdateRequest;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUidScanControl
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
    public function handle(UidScanUpdateRequest $event)
    {
        // TODO
        $uid = $event->uid;
        $scan = $event->scan;
        $scan->committee_member = (rand(0, 100) >= 50);
        $scan->save();
    }
}
