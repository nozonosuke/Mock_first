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

        // pageパラメータ（sell/buy）
        $page = $request->query('page', 'sell');

        $sellItems = $user->items()->latest()->get();
        // 購入した商品
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

    /**
     * プロフィール保存処理
     */
    public function updateProfile(ProfileRequest $request)
    {
        $user = Auth::user();
        $validated = $request->validated();

        /*
        |--------------------------------------------------------------------------
        | プロフィール画像保存
        |--------------------------------------------------------------------------
        */
        if ($request->hasFile('profile_image')) {

            // 既存画像があれば削除
            if ($user->profile_image) {
                Storage::disk('public')->delete($user->profile_image);
            }

            // storage/app/public/profile に保存
            $path = $request->file('profile_image')
                            ->store('profile', 'public');

            $user->profile_image = $path;
        }

        /*
        |--------------------------------------------------------------------------
        | users テーブル更新（ユーザー名・画像）
        |--------------------------------------------------------------------------
        */
        $user->name = $validated['name'];
        $user->save();

        /*
        |--------------------------------------------------------------------------
        | addresses テーブル更新 or 作成
        |--------------------------------------------------------------------------
        */
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