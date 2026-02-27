<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Illuminate\Support\Facades\Auth;
use App\Models\Purchase;

class PurchaseRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $user = auth()->user();
        $hasSessionAddress = session()->has('purchase_address');
        $hasDbAddress = $user && $user->address;

        return [
            // 支払方法は必須
            'payment_method' => ['required', 'string'],

            // 住所がどこにも無い場合のみ購入POSTで必須
            'postal_code' => [($hasSessionAddress || $hasDbAddress) ? 'nullable' : 'required'],
            'address' => [($hasSessionAddress || $hasDbAddress) ? 'nullable' : 'required'],
            'building_name' => ['nullable'],
        ];
    }

    public function messages(): array
    {
        return [
            'payment_method.required' => '支払方法を選択してください',

            'postal_code.required' => '郵便番号を入力してください',
            'address.required' => '住所を入力してください',
        ];
    }

    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator) {
            $user = Auth::user();
            $item = $this->route('item'); // purchase/{item} のルートモデルバインディング

            // item が取得できない場合（念のため）
            if (!$item) {
                $validator->errors()->add('item', '商品が見つかりません。');
                return;
            }

            // 自分の商品は購入できない
            if ((int)$item->user_id === (int)$user->id) {
                $validator->errors()->add('item', '自分が出品した商品は購入できません。');
            }

            // すでに購入済み（誰かが購入済み）なら購入できない
            if (Purchase::where('item_id', $item->id)->exists()) {
                $validator->errors()->add('item', 'この商品はすでに購入されています。');
            }

            // 配送先住所が「セッション」または「DB」に存在することを必須にする
            $sessionAddress = session('purchase_address');
            $dbAddress = $user->address; // User->address リレーション前提

            if (!$sessionAddress && !$dbAddress) {
                $validator->errors()->add('address', '配送先住所を登録してください。');
            }
        });
    }
}