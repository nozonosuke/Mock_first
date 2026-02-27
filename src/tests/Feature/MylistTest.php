<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;

class MylistTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function いいねした商品だけが表示される()
    {
        $user = User::factory()->create();

        $item1 = Item::factory()->create();
        $item2 = Item::factory()->create();

        // item1だけいいね
        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item1->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSeeText($item1->name);
        $response->assertDontSeeText($item2->name);
    }

    /** @test */
    public function マイリスト内の購入済み商品はSOLDと表示される()
    {
        $user = User::factory()->create();

        $item = Item::factory()->create();

        // いいね登録
        Favorite::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        // 購入済みにする
        \App\Models\Purchase::factory()->create([
            'item_id' => $item->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        $response->assertSee($item->name);
        $response->assertSee('SOLD');
    }

    /** @test */
    public function 未認証の場合はマイリストに何も表示されない()
    {
        // 商品を作る（データがある状態を作る）
        $item = Item::factory()->create();

        // 未ログインでアクセス
        $response = $this->get('/?tab=mylist');

        $response->assertStatus(200);

        // 商品名が表示されないことを確認
        $response->assertDontSee($item->name);
    }
}
