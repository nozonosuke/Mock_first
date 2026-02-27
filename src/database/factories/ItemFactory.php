<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ItemFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(), // 自動でユーザー作成
            'name' => $this->faker->word,
            'brand_name' => $this->faker->optional()->company,
            'description' => $this->faker->sentence,
            'price' => $this->faker->numberBetween(100, 10000),
            'image_url' => $this->faker->optional()->imageUrl(),
            'condition' => $this->faker->randomElement(['良好', '目立った傷なし', 'やや傷あり']),
        ];
    }
}


