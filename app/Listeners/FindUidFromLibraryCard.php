<?php

namespace App\Listeners;

use App\Events\ScanCreated;
use App\Events\ScanUpdateRequest;
use App\Events\UidScanUpdateRequest;
use App\Support\UnionCloud\UnionCloud;
use Illuminate\Cache\Repository;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class FindUidFromLibraryCard implements ShouldQueue
{
    /**
     * @var UnionCloud
     */
    private $unionCloud;
    /**
     * @var Repository
     */
    private $cache;

    /**
     * Create the event listener.
     *
     * @param UnionCloud $unionCloud
     */
    public function __construct(UnionCloud $unionCloud, Repository $cache)
    {
        $this->unionCloud = $unionCloud;
        $this->cache = $cache;
    }

    /**
     * Handle the event.
     *
     * @param ScanUpdateRequest $event
     * @return void
     */
    public function handle(ScanUpdateRequest $event)
    {
        $card = $event->scan->card_number;
        $uid = $this->cache->remember(FindUidFromLibraryCard::class . 'card:' . $card, 1500, function() use ($card){
            return $this->unionCloud->getUidFromLibraryCard($card);
        });

        event(new UidScanUpdateRequest($event->scan, $uid));
    }
}
