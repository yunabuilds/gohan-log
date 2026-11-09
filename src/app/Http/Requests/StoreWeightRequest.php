<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreWeightRequest extends FormRequest
{
    public function authorize(): bool
    {
        // ログインの確認はルートの auth でしているので true にする
        return true;
    }

    public function rules(): array
    {
        return [
            // 体重：必須・数字・20〜300・小数第1位まで
            'weight' => 'required|numeric|between:20,300|decimal:0,1',

            // 記録した日：必須・日付・同じ人の同じ日の記録がすでにあればエラー
            'recorded_on' => [
                'required',
                'date',
                Rule::unique('weights')->where('user_id', $this->user()->id),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'weight.required' => '体重を入力してください。',
            'weight.numeric' => '体重は数字で入力してください。',
            'weight.between' => '体重は20〜300の範囲で入力してください。',
            'weight.decimal' => '体重は小数第1位までで入力してください。',
            'recorded_on.required' => '記録した日を入力してください。',
            'recorded_on.date' => '記録した日は日付で入力してください。',
            'recorded_on.unique' => 'この日の体重はすでに記録されています。',
        ];
    }
}