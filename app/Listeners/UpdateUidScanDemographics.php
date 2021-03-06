<?php

namespace App\Listeners;

use App\Events\UidScanUpdateRequest;
use App\Support\UnionCloud\UnionCloud;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class UpdateUidScanDemographics implements ShouldQueue
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
     * @param UidScanUpdateRequest $event
     * @return void
     */
    public function handle(UidScanUpdateRequest $event)
    {
        Redis::throttle('unioncloud')->allow(30)->every(60)->then(function() use ($event) {

            $student = $this->unionCloud->getStudentFromUid($event->uid);
            $scan = $event->scan;
            if($student->programme === false) {
                $programme = [];
            } else {
                $programme = $student->programme[count($student->programme)-1];
            }
            $scan->department = ($student->department?:'N/A');
            $scan->study_type = (!empty($programme)?$programme['study_type']:'N/A');
            $scan->programme_year = (!empty($programme)?$programme['programme_level']:'N/A');
            $scan->age = $student->dob->age;
            $scan->gender = ($student->gender?:'N/A');
            $scan->save();
        }, function() {
            $this->release(rand(40, 90));
        });

    }
}
