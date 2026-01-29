<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;
use App\Models\Address;
use Carbon\Carbon;

class PurchaseController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function show(Item $item)
    {
        $user = Auth::user();
        $address = session('purchase_address') ?? $user->address;

        return view('purchase.purchase', compact('item', 'address'));
    }

    public function editAddress(Item $item)
    {
        $address = session('purchase_address') ?? Auth::user()->address;

        return view('purchase.address', compact('item', 'address'));
    }

    public function updateAddress(Request $request, Item $item)
    {
        $request->validate([
            'postal_code' => 'required',
            'address' => 'required',
            'building_name' => 'nullable'
        ]);

        session([
            'purchase_address' => [
                'postal_code' => $request->postal_code,
                'address' => $request->address,
                'building_name' => $request->building_name,
            ]
        ]);

        return redirect()->route('purchase.purchase', $item);
    }

    public function store(Request $request, Item $item)
    {
        $user = Auth::user();

        // 配送先（セッション or ユーザー住所）
        $addressData = session('purchase_address');

        if ($addressData) {
            // 購入専用の配送先を作成
            $address = Address::create([
                'user_id' => $user->id,
                'postal_code' => $addressData['postal_code'],
                'address' => $addressData['address'],
                'building_name' => $addressData['building_name'],
            ]);
        } else {
            $address = $user->address;
        }

        // 購入データ作成
        Purchase::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
            'price_at_purchase' => $item->price,
            'shipping_address_id' => $address->id,
            'status' => 'purchased',
            'purchased_at' => Carbon::now(),
        ]);

        // セッション削除
        session()->forget('purchase_address');

        return redirect()->route('products.index')->with('success', '購入が完了しました');
    }
}
