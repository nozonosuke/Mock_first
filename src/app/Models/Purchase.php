<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Item;
use App\Models\Address;

class Purchase extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'item_id',
        'price_at_purchase',
        'shipping_address_id',
        'status',
        'purchased_at',
    ];

    /**購入者（User） */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**購入された商品(Item) */
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    /**配送先住所 */
    public function shippingAddress()
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }
}
