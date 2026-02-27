<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Purchase;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;
use Carbon\Carbon;

class PurchaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //ユーザー・住所を取得（今回は1人目を使用）
        $user = User::first();
        $address = Address::where('user_id', $user->id)->first();

        // 念のためガード
        if (! $user || $address){
            return;
        }

        // 商品をランダムに数件購入したことにする
        $items = Item::inRandomOrder()->take(3)->get();

        foreach ($items as $item){
            Purchase::create([
                'user_id' => $user->id,
                'item_id' => $item->id,
                'price_at_purchase' => $item->price,
                'shipping_address_id' => $address->id,
                'status' => 'completed',
                'purchased_at' => Carbon::now()->subDays(rand(1, 30)),
            ]);
        }
    }
}
