<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class AddressFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'postal_code' => str_pad(
                $this->faker->numberBetween(1000000, 9999999),
                7,
                '0',
                STR_PAD_LEFT
            ),
            'address' => $this->faker->address,
            'building_name' => $this->faker->optional()->secondaryAddress,
        ];
    }
}

