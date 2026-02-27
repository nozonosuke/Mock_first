<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function ログイン済みユーザーはコメントを送信できる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post("/item/{$item->id}/comment", [
            'comment' => 'テストコメント'
        ]);

        // DB確認
        $this->assertDatabaseHas('comments', [
            'item_id' => $item->id,
            'user_id' => $user->id,
            'comment' => 'テストコメント',
        ]);

        // 表示確認（コメント数増加）
        $response = $this->get("/item/{$item->id}");
        $response->assertSee('💬 1');
    }

    /** @test */
    public function 未ログインユーザーはコメントを送信できない()
    {
        $item = Item::factory()->create();

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => 'テストコメント'
        ]);

        // リダイレクト確認
        $response->assertRedirect('/login');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function ２５５文字以上のコメントはバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $longComment = str_repeat('あ', 256);

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => $longComment
        ]);

        $response->assertSessionHasErrors('comment');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function コメント未入力はバリデーションエラーになる()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $response = $this->post("/item/{$item->id}/comment", [
            'comment' => ''
        ]);

        $response->assertSessionHasErrors('comment');

        $this->assertDatabaseMissing('comments', [
            'item_id' => $item->id,
        ]);
    }
}
