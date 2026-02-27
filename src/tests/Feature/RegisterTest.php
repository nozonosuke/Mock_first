<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RegisterTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 名前が未入力の場合エラーが画面に表示される()
    {
        // ① まず登録画面を開く
        $this->get('/register');

        // ② その状態でPOST
        $response = $this->followingRedirects()->post('/register', [
            'name' => '',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSee('お名前を入力してください');
    }

    /** @test */
    public function メールアドレスが未入力の場合エラーが画面に表示される()
    {
        $this->get('/register');

        $response = $this->followingRedirects()->post('/register', [
            'name' => '山田太郎',
            'email' => '',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        $response->assertSee('メールアドレスを入力してください');
    }

    /** @test */
    public function パスワードが未入力の場合エラーが画面に表示される()
    {
        // ① 登録画面を開く
        $this->get('/register');

        // ② パスワード未入力で送信
        $response = $this->followingRedirects()->post('/register', [
            'name' => '山田太郎',
            'email' => 'test@example.com',
            'password' => '',
            'password_confirmation' => '',
        ]);

        // ③ メッセージ表示確認
        $response->assertSee('パスワードを入力してください');
    }

    /** @test */
    public function パスワードが7文字以下の場合エラーが画面に表示される()
    {
        $this->get('/register');

        $response = $this->followingRedirects()->post('/register', [
            'name' => '山田太郎',
            'email' => 'test@example.com',
            'password' => '1234567', // 7文字
            'password_confirmation' => '1234567',
        ]);

        $response->assertSee('パスワードは8文字以上で入力してください');
    }

    /** @test */
    public function パスワード確認が一致しない場合エラーが画面に表示される()
    {
        $this->get('/register');

        $response = $this->followingRedirects()->post('/register', [
            'name' => '山田太郎',
            'email' => 'test@example.com',
            'password' => 'password123',
            'password_confirmation' => 'different123',
        ]);

        $response->assertSee('パスワードと一致しません');
    }
    
    /** @test */
    public function 正常に入力された場合ユーザーが登録されプロフィール画面に遷移する()
    {
        $response = $this->post('/register', [
            'name' => '山田太郎',
            'email' => 'success@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // DBに保存されているか確認
        $this->assertDatabaseHas('users', [
            'email' => 'success@example.com',
        ]);

        // リダイレクト確認（例：トップページ）
        $response->assertRedirect('/email/verify');
    }
}
