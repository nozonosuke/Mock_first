<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExhibitionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required'],
            'description' => ['required', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png'],
            'categories' => ['required', 'array'],
            'categories.*' => ['exists:categories,id'],
            'condition' => ['required'],
            'price' => ['required', 'numeric', 'min:0'],
        ];
    }

    public function messages()
    {
        return [
            'name.required' => '商品名は必須です。',

            'description.required' => '商品の説明は必須です。',
            'description.max' => '商品の説明は255文字以内で入力してください。',

            'image.required' => '商品画像を選択してください。',
            'image.image' => '商品画像は画像ファイルを選択してください。',
            'image.mimes' => '商品画像はJPEGまたはPNG形式を選択してください。',

            'categories.required' => 'カテゴリーを1つ以上選択してください。',
            'categories.array' => 'カテゴリーの形式が不正です。',
            'categories.*.exists' => '選択したカテゴリーが不正です。',

            'condition.required' => '商品の状態を選択してください。',

            'price.required' => '販売価格を入力してください。',
            'price.numeric' => '販売価格は数字で入力してください。',
            'price.min' => '販売価格は0円以上で入力してください。',
        ];
    }

    public function attributes()
    {
        return [
            'name' => '商品名',
            'description' => '商品の説明',
            'image' => '商品画像',
            'categories' => 'カテゴリー',
            'condition' => '商品の状態',
            'price' => '販売価格',
        ];
    }
}
