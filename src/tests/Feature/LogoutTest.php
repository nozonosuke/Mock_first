<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログアウトができる()
    {
        // ① ユーザー作成
        $user = User::factory()->create();

        // ② ログイン状態を作る
        $this->actingAs($user);

        // ③ ログアウト実行
        $response = $this->post('/logout');

        // ④ 未ログイン状態になっていることを確認
        $this->assertGuest();

        // ⑤ リダイレクト確認（必要に応じて変更）
        $response->assertRedirect('/');
    }
}
