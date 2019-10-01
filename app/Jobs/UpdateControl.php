<?php

namespace App\Jobs;

use App\Listeners\FindUidFromLibraryCard;
use App\Scan;
use App\Support\Control\Contracts\Repositories\Role as RoleRepository;
use App\Support\Control\Contracts\Repositories\User as UserRepository;
use App\Support\UnionCloud\UnionCloud;
use Illuminate\Bus\Queueable;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Redis;

class UpdateControl implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    /**
     * @var Scan
     */
    private $scan;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;
    /**
     * @var Repository
     */
    private $cache;
    /**
     * @var UnionCloud
     */
    private $unioncloud;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Scan $scan)
    {
        $this->scan = $scan;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(UserRepository $userRepository, RoleRepository $roleRepository, UnionCloud $unionCloud, Repository $cache)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
        $this->cache = $cache;
        $this->unioncloud = $unionCloud;
        Redis::throttle('updatecontrol')->allow(30)->every(60)->then(function() {
            $uid = $this->cache->remember(FindUidFromLibraryCard::class . 'card:' . $this->scan->card_number, 1500, function(){
                return $this->unioncloud->getUidFromLibraryCard($this->scan->card_number);
            });
            try {
                $student = $this->userRepository->findOrCreateByDataId($uid);
                $roles = $this->roleRepository->allFromStudentControlID($student->id());
                $this->scan->committee_member = $roles->count() > 0;
            } catch (\Exception $e) {
                $this->scan->committee_member = false;
            }
            $this->scan->save();
        }, function() {
            $this->release(rand(20, 50));
        });

    }
}
