<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;

class ItemController extends Controller
{
    public function index()
    {
        /**商品一覧取得 */
        $items = Item::with('categories')->latest()->get();

        return view('products.index', compact('items'));
    }

    public function show(Item $item)
    {
        // 商品詳細用：必要な関連をまとめて取得
        $item->load([
            'categories',
            'comments.user',
            'favorites',
        ]);

        return view('items.show', compact('item'));
    }
}
