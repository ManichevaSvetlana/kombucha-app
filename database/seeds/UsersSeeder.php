<?php

use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::insert([
            ['id' => 1, 'first_name' => 'Kombucha', 'last_name' => 'Admin', 'email' => 'admin@kombucha.com', 'password' => bcrypt('123456')],
            
            ['id' => 2, 'first_name' => 'Customer', 'last_name' => 'Test 1', 'email' => 'customer_test_1@kombucha.com', 'password' => bcrypt('123456')],
            ['id' => 3, 'first_name' => 'Customer', 'last_name' => 'Test 2', 'email' => 'customer_test_2@kombucha.com', 'password' => bcrypt('123456')],
            ['id' => 4, 'first_name' => 'Customer', 'last_name' => 'Test 3', 'email' => 'customer_test_3@kombucha.com', 'password' => bcrypt('123456')],
            
            ['id' => 5, 'first_name' => 'Sales Rep', 'last_name' => 'Test 1', 'email' => 'sales_rep_1@kombucha.com', 'password' => bcrypt('123456')],
            ['id' => 6, 'first_name' => 'Sales Rep', 'last_name' => 'Test 2', 'email' => 'sales_rep_2@kombucha.com', 'password' => bcrypt('123456')],
            ['id' => 7, 'first_name' => 'Sales Rep', 'last_name' => 'Test 3', 'email' => 'sales_rep_3@kombucha.com', 'password' => bcrypt('123456')],
        ]);

        \App\UserRole::insert([
            ['role_id' => 1, 'user_id' => 1],

            ['role_id' => 2, 'user_id' => 2],
            ['role_id' => 2, 'user_id' => 3],
            ['role_id' => 2, 'user_id' => 4],

            ['role_id' => 3, 'user_id' => 5],
            ['role_id' => 3, 'user_id' => 6],
            ['role_id' => 3, 'user_id' => 7],
        ]);
    }
}
