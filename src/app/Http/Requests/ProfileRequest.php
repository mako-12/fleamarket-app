<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'profile_image' => 'file|mimes:jpeg,png',
            'name' => 'required|max:20',
            'post_code' => 'required|regex:/^\d{3}-\d{4}$/',
            'address' => 'required',
        ];
    }


    public function messages()
    {
        return [
            'profile_image.mimes' => '画像は.jpegまたは.png形式でアップロードしてください',
            'name.required' => '名前を入力してください',
            'name.min' => '20文字以内で入力してください',
            'post_code.required' => '郵便番号を入力してください',
            'post_code.regex' => 'ハイフン含め8桁で入力してください',
            'address.required' => '住所を入力してください',
        ];
    }
}
