<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\App;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesTableSeeder::class,
            CategoriesTableSeeder::class,
        ]);

        if (App::environment(['local', 'staging', 'testing', 'development'])) {
            $this->call([
                UsersTableSeeder::class,
                TestSeeder::class,
            ]);
        }
    }
}
