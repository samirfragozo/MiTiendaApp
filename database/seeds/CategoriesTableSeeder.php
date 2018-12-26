<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table((new \App\Category)->getTable())->delete();

        factory(App\Category::class, 10)->create();

        Model::reguard();
    }
}
