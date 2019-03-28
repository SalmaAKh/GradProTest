<?php

use Faker\Generator as Faker;

$factory->define(App\Administrator::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
    ];
});


