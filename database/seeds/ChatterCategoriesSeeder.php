<?php

use Illuminate\Database\Seeder;

class ChatterCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \DB::table('chatter_categories')->insert([
            0 => [
                'id'         => 2,
                'parent_id'  => null,
                'order'      => 2,
                'name'       => 'General',
                'color'      => '#2ECC71',
                'slug'       => 'general',
                'created_at' => null,
                'updated_at' => null,
            ],
        ]);
    }
}
