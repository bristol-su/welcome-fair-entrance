<?php

namespace App\Listeners;

use App\Events\ScanCreated;
use App\Events\UidScanUpdateRequest;
use App\Support\UnionCloud\UnionCloud;
use Faker\Generator as Faker;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AddToUnionCloud implements ShouldQueue
{
    /**
     * @var UnionCloud
     */
    private $unionCloud;

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(UnionCloud $unionCloud)
    {
        $this->unionCloud = $unionCloud;
    }

    /**
     * Handle the event.
     *
     * @param ScanCreated $event
     * @return void
     */
    public function handle(UidScanUpdateRequest $event)
    {
        if(config('app.unioncloud.enable')) {
            $this->unionCloud->addToUserGroup($event->uid, config('app.unioncloud.usergroup_id'));
        }
    }
}
