<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 購入ボタンを押すと購入が完了する()
    {
        $buyer = User::factory()->create();
        $item = Item::factory()->create();

        $address = Address::factory()->create([
            'user_id' => $buyer->id,
        ]);

        $this->actingAs($buyer);

        $this->post("/purchase/{$item->id}", [
            'shipping_address_id' => $address->id,
            'payment_method' => 'credit_card',
        ]);

        $this->assertDatabaseHas('purchases', [
            'user_id' => $buyer->id,
            'item_id' => $item->id,
        ]);
    }

    /** @test */
    public function 購入した商品は一覧でSOLDと表示される()
    {
        $buyer = User::factory()->create();
        $item = Item::factory()->create();

        $address = Address::factory()->create([
            'user_id' => $buyer->id,
        ]);

        $this->actingAs($buyer);

        $this->post("/purchase/{$item->id}", [
            'shipping_address_id' => $address->id,
            'payment_method' => 'credit_card',
        ]);

        $response = $this->get('/');

        $response->assertSee('SOLD');
    }

    /** @test */
    public function 購入商品がマイページに表示される()
    {
        $buyer = User::factory()->create();
        $item = Item::factory()->create([
            'name' => 'iPhone'
        ]);

        $address = Address::factory()->create([
            'user_id' => $buyer->id,
        ]);

        $this->actingAs($buyer);

        $this->post("/purchase/{$item->id}", [
            'shipping_address_id' => $address->id,
            'payment_method' => 'credit_card',
        ]);

        $response = $this->get('/mypage?page=buy');

        $response->assertSee('iPhone');
    }
}