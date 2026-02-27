<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\ProfileRequest;
use Illuminate\Http\Request;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $page = $request->query('page', 'sell');

        $sellItems = $user->items()->latest()->get();
        $buyItems = $user->purchases()->with('item')->latest()->get();

        return view('mypage.mypage', compact(
            'user',
            'sellItems',
            'buyItems',
            'page'
        ));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('mypage.profile', compact('user'));
    }

    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        if ($request->hasFile('profile_image')) {

            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            $path = $request->file('profile_image')
                            ->store('profile', 'public');

            $user->profile_image = $path;
        }

        $user->name = $validated['name'];
        $user->save();

        $user->address()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'postal_code'  => $validated['postal_code'],
                'address'      => $validated['address'],
                'building_name'=> $validated['building_name'] ?? null,
            ]
        );

        return redirect('/mypage/profile')
            ->with('success', 'プロフィールを更新しました');
    }
}