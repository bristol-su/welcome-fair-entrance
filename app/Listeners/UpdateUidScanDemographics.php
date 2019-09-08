<?php

namespace App\Listeners;

use App\Events\ScanCreated;
use App\Events\UidScanUpdateRequest;
use Faker\Generator as Faker;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class UpdateUidScanDemographics
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
        $faker = app()->make(Faker::class);
        // TODO
        $scan = $event->scan;
        $scan->department = $faker->randomElement(['ENG', 'SCI', 'HIS', 'GEO', 'MUS', 'THEA', 'COM']);
        $scan->study_type = $faker->randomElement(['full_time', 'part_time']);
        $scan->programme_year = $faker->randomElement([0, 1, 2, 3, 4]);
        $scan->age = $faker->biasedNumberBetween(18, 70, 'sqrt');
        $scan->gender = $faker->randomElement(['male', 'female', 'non-binary', 'other']);
        $scan->save();
    }
}
