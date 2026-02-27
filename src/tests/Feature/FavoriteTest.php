<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねアイコンを押すと登録される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post("/item/{$item->id}/favorite");

        // pivot テーブル確認
        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // いいね数確認
        $response = $this->get("/item/{$item->id}");
        $response->assertSee('♥ 1');
    }

     /** @test */
    public function いいね済みの場合アイコンが変化する()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 事前にいいね登録
        $item->favoredUsers()->attach($user->id);

        $this->actingAs($user);

        $response = $this->get("/item/{$item->id}");

        // liked クラスがあるか（実際のclass名に合わせて）
        $response->assertSee('liked', false);
    }

    /** @test */
    public function 再度押すといいねが解除される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        // 1回目 → 登録
        $this->post("/item/{$item->id}/favorite");

        // 2回目 → 解除
        $this->post("/item/{$item->id}/favorite");

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 表示確認
        $response = $this->get("/item/{$item->id}");
        $response->assertSee('♥ 0');
    }
}
