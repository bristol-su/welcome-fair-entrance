<?php

namespace App\Listeners;

use App\Events\ScanCreated;
use App\Events\UidScanUpdateRequest;
use App\Support\UnionCloud\UnionCloud;
use Faker\Generator as Faker;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class AddToUnionCloud implements ShouldQueue
{
    use InteractsWithQueue;
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
        Redis::throttle('unioncloud-usergroups')->allow(20)->every(60)->then(function() use ($event) {
            if(config('app.unioncloud.enable')) {
                $this->unionCloud->addToUserGroup($event->uid, config('app.unioncloud.usergroup_id'));
            }
        }, function() {
            $this->release(rand(40, 90));
        });
    }
}
