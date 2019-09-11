<?php

namespace App\Listeners;

use App\Events\ScanCreated;
use App\Events\UidScanUpdateRequest;
use App\Support\UnionCloud\UnionCloud;
use Carbon\Carbon;
use Faker\Generator as Faker;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUidScanDemographics
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
     * @param UidScanUpdateRequest $event
     * @return void
     */
    public function handle(UidScanUpdateRequest $event)
    {
        $student = $this->unionCloud->getStudentFromUid($event->uid);
        $scan = $event->scan;
        // TODO
        $scan->department = $student->department;
        $scan->study_type = ($student->programme[0]?$student->programme[0]['study_type']:'N/A');
        $scan->programme_year = ($student->programme[0]?$student->programme[0]['programme_level']:'N/A');
        $scan->age = $student->dob->age;
        $scan->gender = $student->gender;
        $scan->save();
    }
}
