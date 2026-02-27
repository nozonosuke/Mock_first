<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;

class PurchaseFactory extends Factory
{
    public function definition()
    {
        return [
            'user_id' => $user = User::factory(),
            'item_id' => Item::factory(),
            'price_at_purchase' => 1000,
            'shipping_address_id' => Address::factory()->state([
                'user_id' => $user,
            ]),
            'status' => 'completed',
            'purchased_at' => now(),
        ];
    }
}
