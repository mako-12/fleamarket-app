<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\ItemCategoriesTableSeeder;
use Database\Seeders\ItemConditionsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class SearchTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_商品名で部分一致検索ができる()
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

        $response = $this->get('/search?keyword=腕');

        $response->assertStatus(200);
        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');
    }


    public function test_検索状態がマイリストでも保持される()
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

        $response = $this->get('/search?keyword=腕');

        $response = $this->get('/?tab=myist&keyword=腕');
        $response->assertSee('腕時計');
        $response->assertDontSee('HDD');
    }
}
