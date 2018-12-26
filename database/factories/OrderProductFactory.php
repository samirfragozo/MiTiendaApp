<?php

use Faker\Generator as Faker;

$factory->define(App\OrderProduct::class, function (Faker $faker) {
    $quantity = random_int(1, 25);

    return [
        'order_id' => function () {
            return factory(App\Order::class)->create()->id;
        },
        'product_id' => function () {
            return factory(App\Product::class)->create()->id;
        },
        'quantity' => $quantity,
        'historical_price' => function (array $products) {
            return App\Product::find($products['product_id'])->price;
        },
        'subtotal' => function (array $products) use ($quantity) {
            return App\Product::find($products['product_id'])->price * $quantity;
        },
    ];
});
