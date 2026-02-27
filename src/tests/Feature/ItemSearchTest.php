<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Item;

class ItemSearchTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品名で部分一致検索ができる()
    {
        $item1 = Item::factory()->create([
            'name' => 'Apple iPhone'
        ]);

        $item2 = Item::factory()->create([
            'name' => 'Banana'
        ]);

        $item3 = Item::factory()->create([
            'name' => 'Pineapple'
        ]);

        $response = $this->get('/?keyword=app');

        $response->assertStatus(200);

        $response->assertSee($item1->name);
        $response->assertSee($item3->name);
        $response->assertDontSee($item2->name);
    }

    /** @test */
    public function マイリストに遷移しても検索キーワードが保持される()
    {
        $response = $this->get('/?tab=mylist&keyword=test');

        $response->assertStatus(200);

        $response->assertSee('value="test"', false);
    }
}
