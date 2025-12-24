<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ChatMessageRequest extends FormRequest
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
            'message' => 'required|max:400',
            'chat_image' => 'nullable|mimes:jpeg,png|max:2048',

        ];
    }

    public function messages()
    {
        return [
            'message.required' => '本文を入力してください',
            'message.max' => '本文は400文字以内で入力してください',
            'chat_image.mimes' => '「.png」または「.jpeg」形式でアップロードしてください',
            'chat_image.max' => '画像サイズは2MB以内にしてください',
        ];
    }
}
