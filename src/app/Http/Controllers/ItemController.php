<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Category;
use App\Http\Requests\ExhibitionRequest;

class ItemController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $query = Item::with(['categories', 'purchase'])->latest();

        if ($request->filled('keyword')) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        }

        if ($request->get('tab') === 'mylist') {
            if (!$user) {
                return view('products.index', ['items' => collect()]);
            }

            $query->whereHas('favorites', function ($favoriteQuery) use ($user) {
                $favoriteQuery->where('user_id', $user->id);
            });
        } elseif ($user) {
            $query->where('user_id', '!=', $user->id);
        }

        return view('products.index', [
            'items' => $query->get(),
        ]);
    }


    public function show(Item $item)
    {
        
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
        $userId = auth()->id();

        $imagePath = $request->file('image')
            ->store('items', 'public');

        $item = Item::create([
            'user_id' => $userId,
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
