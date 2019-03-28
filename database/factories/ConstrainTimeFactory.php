<?php

use Faker\Generator as Faker;

$factory->define(\App\ConstrainHour::class, function (Faker $faker) {
    return [
         'hour_id' => rand(1,5),
        'day_id' => rand(1,5),
     ];
});
