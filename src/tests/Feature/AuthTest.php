<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    //会員登録画面
    public function test_Register未入力の場合は、バリデーションメッセージを表示()
    {
        $response = $this->post('/register', [
            'name' => '',
            'email' => '',
            'password' => '',
            'password_confirmation' => '',
        ]);
        $response->assertSessionHasErrors([
            'name' => 'お名前を入力してください',
            'email' => 'メールアドレスを入力してください',
            'password' => 'パスワードを入力してください'
        ]);
    }

    public function test_Registerパスワードが7文字以下の場合、バリデーションメッセージを表示()
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '1234567',
            'password_confirmation' => '1234567',
        ]);
        $response->assertSessionHasErrors(['password' => 'パスワードは8文字以上で入力してください']);
    }

    public function test_Registerパスワードが確認用パスワードと一致しない場合、バリデーションメッセージを表示()
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => '12345678',
            'password_confirmation' => 'abcdefgh',
        ]);
        $response->assertSessionHasErrors(['password' => 'パスワードと一致しません']);
    }

    public function test_Register会員登録されてプロフィール画面に遷移されるか()
    {
        $response = $this->post('/register', [
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $this->assertDatabaseHas('users', [
            'email' => 'test@example.com',
        ]);

        $response->assertRedirect('/email/verify');
    }



    //ログイン画面
    public function test__login未入力の場合、バリデーションメッセージを表示()
    {
        $response = $this->post('/login', [
            'email' => '',
            'password' => '',
        ]);

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
            'password' => 'パスワードを入力してください',
        ]);
    }

    public function test_login入力が間違っている場合、バリデーションメっセージを表示()
    {
        $response = $this->post('/login', [
            'email' => 'unique_' . uniqid() . '@example.com',
            'password' => 'password123',
        ]);
        $response->assertSessionHasErrors(['email' => 'ログイン情報が登録されていません']);
    }

    public function test_login正しい情報が入力された場合、ログイン処理が実行される()
    {

        //ユーザーを作成
        User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
        ]);

        $response->assertRedirect('/');
        $this->assertAuthenticated();
    }

    public function test_ログアウトできるかどうか()
    {
        $user = User::create([
            'name' => 'test',
            'email' => 'test@example.com',
            'password' => Hash::make('password123'),
        ]);

        $this->actingAs($user); //ログイン状態にする

        $response = $this->post('/logout');

        $this->assertGuest();

        $response->assertRedirect('/login');
    }
}
