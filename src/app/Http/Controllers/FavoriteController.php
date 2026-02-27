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

        $isFavorited = $item->favoredUsers()
            ->where('user_id', $user->id)
            ->exists();

        if ($isFavorited) {
            $item->favoredUsers()->detach($user->id);
            return back();
        }

        $item->favoredUsers()->attach($user->id);

        return back();
    }
}
