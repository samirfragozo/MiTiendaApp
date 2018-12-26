<?php

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        DB::table((new \App\User)->getTable())->delete();

        factory(App\User::class)->create([
            'email' => 'admin@admin.com',
        ])->assignRole((new \App\Utils\Base())->roles());

        Model::reguard();
    }
}
