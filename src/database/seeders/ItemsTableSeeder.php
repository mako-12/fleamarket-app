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
            'profile_id' => 1,
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
            'profile_id' => 1,
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


        $itemId4 = DB::table('items')->insertGetId([
            'profile_id' => 1,
            'item_image' => 'item_image/Leather+Shoes+Product+Photo.jpg',
            'item_condition_id' => 4,
            'name' => '革靴',
            'brand' => '',
            'detail' => 'クラシックなデザインの革靴',
            'price' => 4000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId4, 'item_category_id' => 1],
            ['item_id' => $itemId4, 'item_category_id' => 5],
        ]);


        $itemId5 = DB::table('items')->insertGetId([
            'profile_id' => 1,
            'item_image' => 'item_image/Living+Room+Laptop.jpg',
            'item_condition_id' => 1,
            'name' => 'ノートPC',
            'brand' => '',
            'detail' => '高性能なノートパソコン',
            'price' => 45000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId5, 'item_category_id' => 2],
        ]);

        $itemId6 =  DB::table('items')->insertGetId([
            'profile_id' => 2,
            'item_image' => 'item_image/Music+Mic+4632231.jpg',
            'item_condition_id' => 2,
            'name' => 'マイク',
            'brand' => 'なし',
            'detail' => '高音質のレコーディング用マイク',
            'price' => 8000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId6, 'item_category_id' => 2],
        ]);


        $itemId7 =  DB::table('items')->insertGetId([
            'profile_id' => 2,
            'item_image' => 'item_image/Purse+fashion+pocket.jpg',
            'item_condition_id' => 3,
            'name' => 'ショルダーバッグ',
            'brand' => '',
            'detail' => 'おしゃれなショルダーバッグ',
            'price' => 3500,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId7, 'item_category_id' => 1],
            ['item_id' => $itemId7, 'item_category_id' => 4],
        ]);

        $itemId8 =  DB::table('items')->insertGetId([
            'profile_id' => 2,
            'item_image' => 'item_image/Tumbler+souvenir.jpg',
            'item_condition_id' => 4,
            'name' => 'タンブラー',
            'brand' => 'なし',
            'detail' => '使いやすいタンブラー',
            'price' => 500,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId8, 'item_category_id' => 10],
        ]);

        $itemId9 =  DB::table('items')->insertGetId([
            'profile_id' => 2,
            'item_image' => 'item_image/Waitress+with+Coffee+Grinder.jpg',
            'item_condition_id' => 1,
            'name' => 'コーヒーミル',
            'brand' => 'Starbacks',
            'detail' => '手動のコーヒーミル',
            'price' => 4000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId9, 'item_category_id' => 3],
            ['item_id' => $itemId9, 'item_category_id' => 10],
        ]);

        $itemId10 =  DB::table('items')->insertGetId([
            'profile_id' => 2,
            'item_image' => 'item_image/外出メイクアップセット.jpg',
            'item_condition_id' => 2,
            'name' => 'メイクセット',
            'brand' => '',
            'detail' => '便利なメイクアップセット',
            'price' => 2500,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $itemId10, 'item_category_id' => 4],
            ['item_id' => $itemId10, 'item_category_id' => 6],
        ]);
    }
}
