<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Item $item)
    {
        $user = Auth::user();

        if ($item->favoredUsers()->where('user_id', $user->id)->exists()) {
            // 解除
            $item->favoredUsers()->detach($user->id);
        } else {
            // 追加
            $item->favoredUsers()->attach($user->id);
        }

        return back();
    }
}
