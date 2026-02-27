<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;

class ItemStoreTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function 出品画面で必要な情報が正しく保存される()
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $this->actingAs($user);

        $category = Category::factory()->create([
            'content' => '家電'
        ]);

        $image = UploadedFile::fake()->image('test.jpg');

        $response = $this->post('/sell', [
            'image' => $image,
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'これはテスト用の商品です',
            'price' => 10000,
            'condition' => '新品',
            'categories' => [$category->id],
        ]);

        // バリデーションエラーがないか確認
        $response->assertSessionHasNoErrors();

        // items テーブル確認
        $this->assertDatabaseHas('items', [
            'user_id' => $user->id,
            'name' => 'テスト商品',
            'brand_name' => 'テストブランド',
            'description' => 'これはテスト用の商品です',
            'price' => 10000,
            'condition' => '新品',
        ]);

        $item = Item::where('name', 'テスト商品')->first();

        // pivotテーブル確認
        $this->assertDatabaseHas('category_item', [
            'item_id' => $item->id,
            'category_id' => $category->id,
        ]);

        // 画像保存確認
        Storage::disk('public')->assertExists($item->image_url);

        $response->assertRedirect('/');
    }
}
