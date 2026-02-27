<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Purchase;
use App\Models\Address;

class UserInfoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function プロフィール情報と出品商品購入商品が正しく表示される()
    {
        // ユーザー作成
        $user = User::factory()->create([
            'name' => '山田太郎',
            'profile_image' => 'test.jpg',
        ]);

        // 出品商品
        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name' => '出品商品A',
        ]);

        // 購入対象の商品（他人が出品）
        $otherUser = User::factory()->create();

        $buyItem = Item::factory()->create([
            'user_id' => $otherUser->id,
            'name' => '購入商品B',
            'price' => 5000,
        ]);

        // 住所
        $address = Address::factory()->create([
            'user_id' => $user->id,
        ]);

        // 購入データ作成
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $buyItem->id,
            'price_at_purchase' => 5000,
            'shipping_address_id' => $address->id,
            'status' => 'purchased',
            'purchased_at' => now(),
        ]);

        $this->actingAs($user);

        // ===== 出品商品タブ確認 =====
        $response = $this->get('/mypage?page=sell');

        $response->assertStatus(200);
        $response->assertSee('山田太郎');
        $response->assertSee('出品商品A');

        // ===== 購入商品タブ確認 =====
        $response = $this->get('/mypage?page=buy');

        $response->assertStatus(200);
        $response->assertSee('購入商品B');
    }
}
