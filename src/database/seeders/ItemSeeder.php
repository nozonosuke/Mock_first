<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Item;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userId = User::firstOrFail()->id;

        /**カテゴリID取得 */
        $fashion = Category::where('content', 'ファッション')->firstOrFail()->id;
        $electronics = Category::where('content', '家電')->firstOrFail()->id;
        $interior = Category::where('content', 'インテリア')->firstOrFail()->id;
        $ladies = Category::where('content', 'レディース')->firstOrFail()->id;
        $mens = Category::where('content', 'メンズ')->firstOrFail()->id;
        $cosme = Category::where('content', 'コスメ')->firstOrFail()->id;
        $books = Category::where('content', '本')->firstOrFail()->id;
        $games = Category::where('content', 'ゲーム')->firstOrFail()->id;
        $sports = Category::where('content', 'スポーツ')->firstOrFail()->id;
        $kitchen = Category::where('content', 'キッチン')->firstOrFail()->id;
        $handmade = Category::where('content', 'ハンドメイド')->firstOrFail()->id;
        $accessories = Category::where('content', 'アクセサリー')->firstOrFail()->id;
        $toys = Category::where('content', 'おもちゃ')->firstOrFail()->id;
        $babygoods = Category::where('content', 'ベビー・キッズ')->firstOrFail()->id;

        $items = [
            [
                'data' => [
                    'name' => '腕時計',
                    'brand_name' => 'Rolax',
                    'description' => 'スタイリッシュなデザインのメンズ腕時計',
                    'price' => 15000,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Armani+Mens+Clock.jpg',
                    'condition' => '良好',
                ],
                'categories' => [$fashion],
            ],

            [
                'data' => [
                    'name' => 'HDD',
                    'brand_name' => '西芝',
                    'description' => '高速で信頼性の高いハードディスク',
                    'price' => 5000,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/HDD+Hard+Disk.jpg',
                    'condition' => '目立った傷や汚れなし',
                ],
                'categories' => [$electronics],
                
            ],

            [
                'data' => [
                    'name' => '玉ねぎ3束',
                    'brand_name' => 'なし',
                    'description' => '新鮮な玉ねぎ3束のセット',
                    'price' => 300,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/iLoveIMG+d.jpg',
                    'condition' => 'やや傷や汚れあり',
                ],
                'categories' => [$kitchen],
            ],

            [
                'data' => [
                    'name' => '革靴',
                    'brand_name' => '',
                    'description' => 'クラシックなデザインの革靴',
                    'price' => 4000,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Leather+Shoes+Product+Photo.jpg',
                    'condition' => '状態が悪い',
                ],
                'categories' => [$fashion, $mens],
            ],

            [
                'data' => [
                    'name' => 'ノートPC',
                    'brand_name' => '',
                    'description' => '高性能なノートパソコン',
                    'price' => 45000,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Living+Room+Laptop.jpg',
                    'condition' => '良好',
                ],
                'categories' => [$electronics],
            ],

            [
                'data' => [
                    'name' => 'マイク',
                    'brand_name' => 'なし',
                    'description' => '高音質のレコーディング用マイク',
                    'price' => 8000,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Music+Mic+4632231.jpg',
                    'condition' => '目立った傷や汚れなし',
                ],
                'categories' => [$electronics],
            ],

            [
                'data' => [
                    'name' => 'ショルダーバッグ',
                    'brand_name' => '',
                    'description' => 'おしゃれなショルダーバッグ',
                    'price' => 3500,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Purse+fashion+pocket.jpg',
                    'condition' => 'やや傷や汚れあり',
                ],
                'categories' => [$fashion, $ladies],
            ],

            [
                'data' => [
                    'name' => 'タンブラー',
                    'brand_name' => 'なし',
                    'description' => '使いやすいタンブラー',
                    'price' => 500,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Tumbler+souvenir.jpg',
                    'condition' => '状態が悪い',
                ],
                'categories' => [$kitchen, $sports],
            ],

            [
                'data' => [
                    'name' => 'コーヒーミル',
                    'brand_name' => 'Starbacks',
                    'description' => '手動のコーヒーミル',
                    'price' => 4000,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/Waitress+with+Coffee+Grinder.jpg',
                    'condition' => '良好',
                ],
                'categories' => [$kitchen],
            ],

            [
                'data' => [
                    'name' => 'メイクセット',
                    'brand_name' => '',
                    'description' => '便利なメイクアップセット',
                    'price' => 2500,
                    'image_url' => 'https://coachtech-matter.s3.ap-northeast-1.amazonaws.com/image/%E5%A4%96%E5%87%BA%E3%83%A1%E3%82%A4%E3%82%AF%E3%82%A2%E3%83%83%E3%83%95%E3%82%9A%E3%82%BB%E3%83%83%E3%83%88.jpg',
                    'condition' => '目立った傷や汚れなし',
                ],
                'categories' => [$cosme, $fashion],
            ],

        ];

        foreach ($items as $item) {

        // 画像保存
        $imageContents = file_get_contents($item['data']['image_url']);
        $extension = pathinfo($item['data']['image_url'], PATHINFO_EXTENSION);
        $fileName = Str::uuid() . '.' . $extension;
        $path = 'items/' . $fileName;

        Storage::disk('public')->put($path, $imageContents);

        // Item作成
        $itemModel = Item::create([
            'user_id'    => $userId,
            'name'       => $item['data']['name'],
            'brand_name' => $item['data']['brand_name'],
            'description'=> $item['data']['description'],
            'price'      => $item['data']['price'],
            'image_url'  => $path,
            'condition'  => $item['data']['condition'],
        ]);

        // カテゴリ紐付け（多対多）
        $itemModel->categories()->attach($item['categories']);
        }
    }
}
