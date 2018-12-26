<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table(config('permission.table_names.roles'))->delete();


        foreach ((new \App\Utils\Base())->roles() as $rol) Role::create(['name' => $rol]);
    }
}
