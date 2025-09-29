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

class CommentTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_ログイン済みのユーザーはコメントを送信できる()
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

        $response = $this->actingAs($user)->post('/item/' . $item1->id . '/comment', [
            'content' => 'テストコメントです',
        ]);

        $this->assertDatabaseHas('comments', [
            'item_id' => $item1->id,
            'profile_id' => $profile->id,
            'content' => 'テストコメントです',
        ]);

        $response->assertStatus(302);
    }

    public function test_ログイン前のユーザーはコメント送信できない()
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


        Auth::logout();
        $this->flushSession();
        $this->assertGuest();

        $response = $this->post('/item/' . $item1->id . '/comment', [
            'content' => 'テストコメントです',
        ]);


        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item1->id,
            'content' => 'テストコメントです',
        ]);
    }

    public function test_255文字以上の場合、バリデーションメッセージを表示()
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

        $longComment = str_repeat('あ', 256);

        $response = $this->actingAs($user)->post('/item/' . $item1->id . '/comment', [
            'content' => $longComment,
        ]);

        $response->assertSessionHasErrors(['content']);
    }
}
