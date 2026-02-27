<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;

class PurchaseAddressTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 登録した住所が購入画面に反映される()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        $this->post("/purchase/address/{$item->id}", [
            'postal_code' => '1234567',
            'address' => '東京都渋谷区',
            'building_name' => 'テストビル'
        ]);

        $response = $this->get("/purchase/{$item->id}");

        $response->assertSee('1234567');
        $response->assertSee('東京都渋谷区');
        $response->assertSee('テストビル');
    }

    /** @test */
    public function 変更した住所で購入すると正しく紐付く()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $this->actingAs($user);

        // ① 住所変更
        $this->post("/purchase/address/{$item->id}", [
            'postal_code' => '9876543',
            'address' => '大阪府大阪市',
            'building_name' => 'サンプルマンション',
        ]);

        // ② 購入実行（🔥 payment_method追加）
        $this->post("/purchase/{$item->id}", [
            'payment_method' => 'credit_card',
        ]);

        // ③ addressesに保存確認
        $this->assertDatabaseHas('addresses', [
            'user_id' => $user->id,
            'postal_code' => '9876543',
            'address' => '大阪府大阪市',
            'building_name' => 'サンプルマンション',
        ]);

        // ④ purchases確認
        $this->assertDatabaseHas('purchases', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}