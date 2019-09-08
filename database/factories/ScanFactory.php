<?php

use App\Scan;
use Faker\Generator as Faker;

$factory->define(Scan::class, function(Faker $faker) {
    return [
        'card_number' => $faker->creditCardNumber,
        'committee_member' => $faker->boolean,
        'department' => $faker->randomElement(['ENG', 'SCI', 'HIS', 'GEO', 'MUS', 'THEA', 'COM']),
        'study_type' => $faker->randomElement(['full_time', 'part_time']),
        'programme_year' => $faker->randomElement([0, 1, 2, 3, 4]),
        'age' => $faker->biasedNumberBetween(18, 70, 'sqrt'),
        'gender' => $faker->randomElement(['male', 'female', 'non-binary', 'other']),
        'scanned_at' => $faker->dateTimeBetween('-10 hours', 'now')
    ];
});
