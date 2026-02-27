<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\Address;
use App\Http\Requests\PurchaseRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function store(PurchaseRequest $request, Item $item)
    {
        $user = Auth::user();

        $addressData = session('purchase_address');

        if ($addressData) {
            $address = Address::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'postal_code'    => $addressData['postal_code'],
                    'address'        => $addressData['address'],
                    'building_name'  => $addressData['building_name'],
                ]
            );
        } else {

            $address = $user->address;
        }

        if (!$address) {
            $address = Address::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'postal_code' => '0000000',
                    'address' => '未設定',
                    'building_name' => null,
                ]
            );
        }

        Purchase::create([
            'user_id'             => $user->id,
            'item_id'             => $item->id,
            'price_at_purchase'   => $item->price,
            'shipping_address_id' => $address->id,
            'status'              => 'purchased',
            'purchased_at'        => Carbon::now(),
        ]);

        session()->forget('purchase_address');

        return redirect()->route('products.index')->with('success', '購入が完了しました');
    }
}