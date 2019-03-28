<?php

use Faker\Generator as Faker;

$factory->define(App\Instructor::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            $user_id = factory(App\User::class)->create()->id;


            return $user_id;
        },
    ];
});
