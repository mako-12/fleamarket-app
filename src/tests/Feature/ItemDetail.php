<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Item;
use App\Models\User;
use App\Models\Address;
use App\Models\Comment;
use App\Models\Profile;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Testing\WithFaker;
use Database\Seeders\ItemCategoriesTableSeeder;
use Database\Seeders\ItemConditionsTableSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemDetail extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_商品詳細ページに必要な情報が表示される()
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

        $item = Item::create([
            'profile_id' => $profile->id,
            'item_image' => 'item_image/Armani+Mens+Clock.jpg',
            'item_condition_id' => 1,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $item->id, 'item_category_id' => 1],
            ['item_id' => $item->id, 'item_category_id' => 5],
        ]);

        $comment = Comment::create([
            'item_id' => $item->id,
            'profile_id' => $profile->id,
            'content' => 'コメント内容',
        ]);

        $response = $this->get('/item/' . $item->id);


        $response->assertSee('<img', false);
        $response->assertSee('storage/' . $item->item_image);
        $response->assertSee('腕時計');
        $response->assertSee('Rolax');
        $response->assertSee('15,000');
        $response->assertSee((string)$item->favoriteBy->count(0));
        $response->assertSee((string)$item->comments->count(1));

        $response->assertSee('スタイリッシュなデザインのメンズ腕時計');
        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
        $response->assertSee('良好');
        $response->assertSee('michi');
        $response->assertSee('コメント内容');
        $response->assertSee('コメント(1)');
    }

    public function test_複数選択されたカテゴリが表示されている()
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

        $item = Item::create([
            'profile_id' => $profile->id,
            'item_image' => 'item_image/Armani+Mens+Clock.jpg',
            'item_condition_id' => 1,
            'name' => '腕時計',
            'brand' => 'Rolax',
            'detail' => 'スタイリッシュなデザインのメンズ腕時計',
            'price' => 15000,
        ]);

        DB::table('item_category_item')->insert([
            ['item_id' => $item->id, 'item_category_id' => 1],
            ['item_id' => $item->id, 'item_category_id' => 5],
            ['item_id' => $item->id, 'item_category_id' => 12],
        ]);

        $response = $this->get('/item/' . $item->id);

        $response->assertSee('ファッション');
        $response->assertSee('メンズ');
        $response->assertSee('アクセサリー');
    }
}
