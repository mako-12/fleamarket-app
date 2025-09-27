<?php

namespace Tests\Feature;

use Stripe\Product;
use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use App\Models\Profile;
use App\Models\ItemCategory;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ItemsTableSeeder;
use Database\Seeders\ProfilesTableSeeder;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\ItemCategoriesTableSeeder;
use Database\Seeders\ItemConditionsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExhibitionTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_全商品を取得できる()
    {
        $this->seed(ItemCategoriesTableSeeder::class);
        $this->seed(ItemConditionsTableSeeder::class);

        $user = User::factory()->create();
        $address = Address::factory()->create();

        $profile = Profile::create([
            'id' => 1,
            'user_id' => $user->id,
            'address_id' => $address->id,
            'name' => 'michi',
            'profile_image' => 'item_image/kkrn_icon_user_4.jpg ',
        ]);

        $item1 = Item::create([
            'profile_id' => $profile->id,
            'item_image' => 'item_image/Armani+Mens+Clock.jpg',
            'item_condition_id' => 1,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $item1->id, 'item_category_id' => 1],
            ['item_id' => $item1->id, 'item_category_id' => 5],
        ]);


        $item2 = DB::table('items')->insertGetId([
            'profile_id' => $profile->id,
            'item_image' => 'item_image/HDD+Hard+Disk.jpg',
            'item_condition_id' => 2,
            'name' => 'HDD',
            'brand' => '西芝',
            'detail' => '高速で信頼性の高いハードディスク',
            'price' => 5000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $item2, 'item_category_id' => 2]
        ]);

        $item3 = DB::table('items')->insertGetId([
            'profile_id' => $profile->id,
            'item_image' => 'item_image/iLoveIMG+d.jpg',
            'item_condition_id' => 3,
            'name' => '玉ねぎ3束',
            'brand' => 'なし',
            'detail' => '新鮮な玉ねぎ3束のセット',
            'price' => 300,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $item3, 'item_category_id' => 10]
        ]);

        $response = $this->get('/');
        $response->assertSee('腕時計');
        $response->assertSee('HDD');
        $response->assertSee('玉ねぎ3束');
    }




    public function test_購入済みの商品はsoldと表示される()
    {
        $this->seed(ItemCategoriesTableSeeder::class);
        $this->seed(ItemConditionsTableSeeder::class);

        $user = User::factory()->create();
        $address = Address::factory()->create();

        $profile = Profile::create([
            'id' => 1,
            'user_id' => $user->id,
            'address_id' => $address->id,
            'name' => 'michi',
            'profile_image' => 'item_image/kkrn_icon_user_4.jpg',
        ]);

        $item1 = Item::create([
            'profile_id' => $profile->id,
            'item_image' => 'item_image/Armani+Mens+Clock.jpg',
            'item_condition_id' => 1,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $item1->id, 'item_category_id' => 1],
            ['item_id' => $item1->id, 'item_category_id' => 5],
        ]);

        DB::table('purchases')->insert([
            'item_id' => $item1->id,
            'profile_id' => $profile->id,
            'payment_method' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/');
        $response->assertSee('sold');
    }


    public function test_自分が出品した商品は表示されない()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user);

        $this->seed(ItemCategoriesTableSeeder::class);
        $this->seed(ItemConditionsTableSeeder::class);

        $address = Address::factory()->create();

        $profile = Profile::create([
            'id' => 1,
            'user_id' => $user->id,
            'address_id' => $address->id,
            'name' => 'michi',
            'profile_image' => 'item_image/kkrn_icon_user_4.jpg',
        ]);

        $item1 = Item::create([
            'profile_id' => $profile->id,
            'item_image' => 'item_image/Armani+Mens+Clock.jpg',
            'item_condition_id' => 1,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ]);

        $response = $this->get('/');
        $response->assertDontSee('腕時計');


        Auth::logout();  //最後にログアウトしておくため
        $this->flushSession();
    }
}
