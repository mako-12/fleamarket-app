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
        $itemId1 = DB::table('items')->insertGetId([
            'profile_id' => 1,
            'item_image' => 'item_image/Armani+Mens+Clock.jpg',
            'item_condition_id' => 1,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId1, 'item_category_id' => 1],
            ['item_id' => $itemId1, 'item_category_id' => 5],
        ]);

        $itemId2 = DB::table('items')->insertGetId([
            'profile_id' => 2,
            'item_image' => 'item_image/HDD+Hard+Disk.jpg',
            'item_condition_id' => 2,
            'name' => 'HDD',
            'brand' => '西芝',
            'detail' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId2, 'item_category_id' => 2]
        ]);

        $itemId3 = DB::table('items')->insertGetId([
            'profile_id' => 2,
            'item_image' => 'item_image/iLoveIMG+d.jpg',
            'item_condition_id' => 3,
            'name' => '玉ねぎ3束',
            'brand' => 'なし',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'price' => 300,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId3, 'item_category_id' => 10]
        ]);
    }
}
