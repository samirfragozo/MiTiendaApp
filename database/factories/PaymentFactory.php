<?php

use Faker\Generator as Faker;

$factory->define(App\Payment::class, function (Faker $faker) {
    return [
        'value' => $faker->randomFloat(2, 10000, 100000),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'store_id' => function () {
            return factory(App\Store::class)->create()->id;
        },
    ];
});
