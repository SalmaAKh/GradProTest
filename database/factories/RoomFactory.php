<?php

use Faker\Generator as Faker;

$factory->define(\App\Room::class, function (Faker $faker) {
    return [
        'room_id' => "H_CMPE_".$faker->numberBetween(1,1000),
        'capacity' => rand(40,80),
        'room_type' => rand(1,3),
     ];
});

