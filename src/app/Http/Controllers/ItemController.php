<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;
use Illuminatie\Support\Facades\Storage;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        /**商品一覧取得 */
        $query = Item::with(['categories', 'purchase'])->latest();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        // ⭐ マイリスト表示（/?tab=mylist）
        if ($request->get('tab') === 'mylist' && auth()->check()) {
            $query->whereHas('favorites', function ($q) {
                $q->where('user_id', auth()->id());
            });
        }

        $items = $query->get();

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

    public function create()
    {
        $categories = Category::all();

        return view('items.create', compact('categories'));
    }

    public function store(ExhibitionRequest $request)
    {
        $imagePath = $request->file('image')->store('items', 'public');

        $item = Item::create([
            'user_id' => auth()->id(),
            'name' => $request->name,
            'brand_name' => $request->brand_name,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
            'image_url' => $imagePath,
        ]);

        $item->categories()->sync($request->categories);

        return redirect()->route('products.index');
    }
}
