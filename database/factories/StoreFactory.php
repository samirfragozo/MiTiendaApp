<?php

use Faker\Generator as Faker;

$factory->define(App\Store::class, function (Faker $faker) {
    return [
        'document' => $faker->unique()->randomNumber(9),
        'name' => $faker->company,
        'address' => $faker->streetAddress,
        'neighborhood' => $faker->streetName,
        'phone' => $faker->e164PhoneNumber,
        'cellphone' => $faker->e164PhoneNumber,
        'latitude' => $this->faker->latitude(10.45, 10.48),
        'longitude' => $this->faker->longitude(-73.25, -73.26),
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'provider' => 0,
        'active' => 1,
    ];
});
