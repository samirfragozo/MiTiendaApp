<?php

use Illuminate\Database\Seeder;

class TestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws Exception
     */
    public function run()
    {
        factory(App\User::class, 50)->create();

        factory(App\Store::class, 50)->create();

        factory(App\Store::class, 25)->create([
            'latitude' => null,
            'longitude' => null,
            'provider' => 1,
        ]);

        factory(App\Store::class, 5)->create([
            'user_id' => 1,
        ]);

        factory(App\Store::class)->create([
            'latitude' => null,
            'longitude' => null,
            'user_id' => 1,
            'provider' => 1,
        ]);

        for ($i = 0; $i < 5000; $i++) {
            factory(App\Product::class)->create([
                'category_id' => random_int(1, \App\Category::count()),
                'store_id' => random_int(1, \App\Store::count()),
            ]);
        }

        for ($i = 1; $i <= 1000; $i++) {
            $user_id = random_int(1, \App\User::count());
            $store_id = random_int(1, \App\Store::count());

            $order = factory(App\Order::class)->create([
                'user_id' => $user_id,
                'store_id' => $store_id,
            ]);

            factory(App\Payment::class)->create([
                'user_id' => $user_id,
                'store_id' => $store_id,
            ]);


            $products = App\Product::where('store_id', $order->store_id)->get()->shuffle();
            $products = $products->take(random_int(1, 15));

            $products->each(function ($item) use ($order) {
                factory(App\OrderProduct::class)->create([
                    'order_id' => $order->id,
                    'product_id' => $item->id,
                ]);
            });
        }
    }
}
