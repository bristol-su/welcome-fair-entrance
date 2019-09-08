<?php

namespace App\Events;

use App\Scan;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;

class ScanUpdateRequest
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    /**
     * @var Scan
     */
    public $scan;

    /**
     * Create a new event instance.
     *
     * @param Scan $scan
     */
    public function __construct(Scan $scan)
    {
        $this->scan = $scan;
    }

}
