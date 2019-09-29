<?php

namespace App\Listeners;

use App\Events\ScanCreated;
use App\Events\UidScanUpdateRequest;
use App\Support\Control\Contracts\Repositories\Role as RoleRepository;
use App\Support\Control\Contracts\Repositories\User as UserRepository;
use App\Support\Control\Control;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redis;

class UpdateUidScanControl implements ShouldQueue
{
    use InteractsWithQueue;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var RoleRepository
     */
    private $roleRepository;

    /**
     * Create the event listener.
     *
     * @param UserRepository $userRepository
     * @param RoleRepository $roleRepository
     */
    public function __construct(UserRepository $userRepository, RoleRepository $roleRepository)
    {
        $this->userRepository = $userRepository;
        $this->roleRepository = $roleRepository;
    }

    /**
     * Handle the event.
     *
     * @param ScanCreated $event
     * @return void
     */
    public function handle(UidScanUpdateRequest $event)
    {
        $scan = $event->scan;
        try {
            $student = $this->userRepository->findOrCreateByDataId($event->uid);
            $roles = $this->roleRepository->allFromStudentControlID($student->id());
            $scan->committee_member = $roles->count() > 0;
        } catch (\Exception $e) {
            $scan->committee_member = false;
        }
        $scan->save();
    }
}
