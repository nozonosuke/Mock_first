<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use App\Models\Favorite;
use App\Models\Comment;

class ItemDetailTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 商品詳細ページに必要な情報が表示される()
    {
        // 出品ユーザー
        $seller = User::factory()->create();

        $item = Item::factory()->create([
            'user_id' => $seller->id,
            'name' => 'iPhone',
            'brand_name' => 'Apple',
            'price' => 100000,
            'description' => '最新モデルです',
            'condition' => '良好',
        ]);

        // カテゴリ作成
        $category = Category::factory()->create([
            'content' => '家電'
        ]);

        // 多対多紐付け
        $item->categories()->attach($category->id);

        // いいね（2件）
        Favorite::factory()->count(2)->create([
            'item_id' => $item->id,
        ]);

        // コメントユーザー
        $commentUser = User::factory()->create([
            'name' => '田中太郎'
        ]);

        Comment::factory()->create([
            'item_id' => $item->id,
            'user_id' => $commentUser->id,
            'comment' => '欲しいです！'
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        // 商品基本情報
        $response->assertSee('iPhone');
        $response->assertSee('Apple');
        $response->assertSee('¥100,000');
        $response->assertSee('最新モデルです');
        $response->assertSee('良好');

        // カテゴリ
        $response->assertSee('家電');

        // いいね数（2）
        $response->assertSee('2');

        // コメント数（1）
        $response->assertSee('1');

        // コメント内容
        $response->assertSee('欲しいです！');

        // コメントユーザー
        $response->assertSee('田中太郎');
    }

    /** @test */
    public function 複数選択されたカテゴリが表示される()
    {
        $item = Item::factory()->create();

        $category1 = Category::factory()->create([
            'content' => '家電'
        ]);

        $category2 = Category::factory()->create([
            'content' => 'インテリア'
        ]);

        // 多対多紐付け
        $item->categories()->attach([
            $category1->id,
            $category2->id
        ]);

        $response = $this->get("/item/{$item->id}");

        $response->assertStatus(200);

        $response->assertSee($category1->content);
        $response->assertSee($category2->content);
    }
}
