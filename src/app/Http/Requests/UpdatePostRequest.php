<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        // 「自分の投稿か」はコントローラーで Policy を使って確認する
        return true;
    }

    public function rules(): array
    {
        return [
            'image' => 'nullable|image|max:10240',       // 写真：差し替えるときだけ（任意）
            'dish_name' => 'required|string|max:100',
            'calories' => 'required|integer|min:0',
            'eaten_on' => 'required|date',
            'memo' => 'nullable|string',
        ];
    }

    public function messages(): array
    {
        return [
            'image.image' => '写真は画像ファイルを選んでください。',
            'image.max' => '写真は10MBまでです。',
            'image.uploaded' => '写真のアップロードに失敗しました。10MBまでの画像を選んでください。',
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