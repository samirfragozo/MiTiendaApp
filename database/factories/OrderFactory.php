<?php

use Faker\Generator as Faker;

$factory->define(App\Order::class, function (Faker $faker) {
    return [
        'status' => $faker->randomElement(array_keys(__('app.selects.orders.status'))),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'store_id' => function () {
            return factory(App\Store::class)->create()->id;
        },
    ];
});
