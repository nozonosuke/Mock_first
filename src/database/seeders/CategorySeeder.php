<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            'ファッション',
            '家電',
            '食品',
            'キッチン',
            'コスメ・美容',
        ];

        foreach ($categories as $category) {
            Category::create([
                'content' => $category,
            ]);
        }
    }
}
