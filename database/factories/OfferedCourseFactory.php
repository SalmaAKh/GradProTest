<?php

use Faker\Generator as Faker;

$factory->define(App\OfferedCourse::class, function (Faker $faker) {


    return [
        'program_curriculum_id' => $faker->randomElement(\App\ProgramCurriculum::all()->pluck('id')->toArray()),
        'instructor_id' => $faker->randomElement(\App\Instructor::all()->pluck('id')->toArray()),
        'day_id' => rand(1,5),
        'hour_id' => rand(1,5),
        'room_id' => rand(1,24),
        'event_type' => rand(1,3),
    ];
});
