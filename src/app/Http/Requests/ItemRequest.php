<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ItemRequest extends FormRequest
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
            'name' => 'required',
            'detail' => 'required|max:255',
            'item_image' => 'required|image|mimes:jpeg,png',
            'categories' => 'required|array|min:1',
            'item_condition_id' => 'required|exists:item_conditions,id',
            'price' => 'required|integer|min:1',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'お名前を入力してください',
            'detail.required' => '商品説明を入力してください',
            'item_image.required' => '商品画像を選択してください',
            'item_image.mimes' => '画像は.jpegまたは.png形式でアップロードしてください',
            'categories.required' => 'カテゴリーを選択してください',
            'item_condition_id.required' => '商品の状態を選択してください',
            'price.required' => '商品価格を入力してください',
        ];
    }
}
