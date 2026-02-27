<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Address;

class UserProfileEditTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function プロフィール編集画面に初期値が正しく表示される()
    {
        $user = User::factory()->create([
            'name' => '山田太郎',
            'profile_image' => 'test.jpg',
        ]);

        Address::create([
            'user_id' => $user->id,
            'postal_code' => '1234567',
            'address' => '東京都渋谷区',
            'building_name' => 'テストビル',
        ]);

        $this->actingAs($user);

        $response = $this->get('/mypage/profile');

        $response->assertStatus(200);

        // ユーザー名
        $response->assertSee('value="山田太郎"', false);

        // 郵便番号
        $response->assertSee('value="1234567"', false);

        // 住所
        $response->assertSee('value="東京都渋谷区"', false);

        // 建物名
        $response->assertSee('value="テストビル"', false);
    }
}
