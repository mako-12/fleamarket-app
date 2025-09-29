<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\ItemCategoriesTableSeeder;
use Database\Seeders\ItemConditionsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MyListTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_いいねした商品がマイリストに表示される()
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


        DB::table('favorites')->insert([
            'item_id' => $item1->id,
            'profile_id' => $profile->id,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $response = $this->get('/?tab=mylist');

        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');
    }




    public function test_購入済の商品はsoldと表示される()
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

        $response = $this->get('/?tab=myist');
        $response->assertSee('sold');
    }
}
