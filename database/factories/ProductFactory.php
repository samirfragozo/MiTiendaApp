<?php

use Faker\Generator as Faker;

$factory->define(App\Product::class, function (Faker $faker) {
    return [
        'name' => $faker->sentence(3, false),
        'price' => $faker->randomFloat(2, 1000, 10000),
        'category_id' => function () {
            return factory(App\Category::class)->create()->id;
        },
        'description' => $faker->text(200),
        'store_id' => function () {
            return factory(App\Store::class)->create()->id;
        },
        'active' => 1,
    ];
});
