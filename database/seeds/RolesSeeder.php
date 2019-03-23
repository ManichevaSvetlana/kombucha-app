<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Role::insert([
           ['id' => 1, 'name' => 'Admin', 'active' => 1],
           ['id' => 2, 'name' => 'Customer', 'active' => 1],
           ['id' => 3, 'name' => 'Sales Representative', 'active' => 1],
        ]);
    }
}
