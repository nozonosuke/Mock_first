<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 全商品を取得できる()
    {
        // 商品3件作成
        $items = Item::factory()->count(3)->create();

        // 商品ページ（/）にアクセス
        $response = $this->get('/');

        $response->assertStatus(200);

        foreach ($items as $item) {
            $response->assertSee($item->name);
        }
    }

    /** @test */
    public function 購入済み商品はSoldと表示される()
    {
        $item = \App\Models\Item::factory()->create();

        // この商品を購入済みにする
        \App\Models\Purchase::factory()->create([
            'item_id' => $item->id,
        ]);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertSee($item->name);

        // Soldが表示されているか確認
        $response->assertSee('SOLD');
    }

    /** @test */
    public function 自分が出品した商品は表示されない()
    {
        $user = \App\Models\User::factory()->create();

        $item = \App\Models\Item::factory()->create([
            'user_id' => $user->id,
        ]);

        $this->actingAs($user);

        $response = $this->get('/');

        $response->assertStatus(200);

        $response->assertDontSeeText($item->name);
    }

}
