<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $item = [
            'item_category_id' => 5,
            'item_condition_id' => 1,
            'item_image' => 'storage/item_image/Armani+Mens+Clock.jpg',
            'name' => '腕時計',
            'brand' => 'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ];
        DB::table('Items')->insert($item);
    }
}
