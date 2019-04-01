<?php

use Faker\Generator as Faker;

$factory->define(App\ProgramCurriculum::class, function (Faker $faker) {
    return [
        'course_name' => $faker->word,
        'course_code' => 'CMPE_'.$faker->numberBetween(100,499),
        'semester' => rand(1,8),
         'year' => rand(1,4),
        'credit' => rand(3,4),
        'department_id' => 1,
        'lab_type'=> rand(0,2)

    ];
});

