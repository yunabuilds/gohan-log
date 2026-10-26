<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        // ログインの確認はルートの auth でしているので true にする
        // （false のままだと、送信すると必ず 403 になる）
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => 'required|image|max:10240',       // 写真：必須・画像だけ・10MB まで
            'dish_name' => 'required|string|max:100',    // 料理名：必須・100文字まで
            'calories' => 'required|integer|min:0',      // カロリー：必須・0以上の整数
            'eaten_on' => 'required|date',               // 食べた日：必須・日付
            'memo' => 'nullable|string',                 // メモ：任意
        ];
    }

    public function messages(): array
    {
        return [
            'image.required' => '写真を選んでください。',
            'image.image' => '写真は画像ファイルを選んでください。',
            'image.max' => '写真は10MBまでです。',
            'dish_name.required' => '料理名を入力してください。',
            'dish_name.max' => '料理名は100文字までです。',
            'calories.required' => 'カロリーを入力してください。',
            'calories.integer' => 'カロリーは整数で入力してください。',
            'calories.min' => 'カロリーは0以上で入力してください。',
            'eaten_on.required' => '食べた日を入力してください。',
            'eaten_on.date' => '食べた日は日付で入力してください。',
        ];
    }
}