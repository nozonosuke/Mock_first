<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

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
        $address = auth::user()->address;

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

        return redirect()->route('purchase.show', $item);
    }
}
