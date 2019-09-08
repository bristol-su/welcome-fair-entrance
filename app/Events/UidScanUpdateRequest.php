<?php

namespace App\Events;

use App\Scan;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class UidScanUpdateRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Scan
     */
    public $scan;
    public $uid;

    /**
     * Create a new event instance.
     *
     * @param Scan $scan
     */
    public function __construct(Scan $scan, $uid)
    {
        $this->scan = $scan;
        $this->uid = $uid;
    }

}
