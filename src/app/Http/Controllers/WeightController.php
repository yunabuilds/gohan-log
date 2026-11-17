<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreWeightRequest;
use Illuminate\Database\UniqueConstraintViolationException;

class WeightController extends Controller
{
    // 体重の記録フォームを表示する
    public function create()
    {
        return view('weights.create');
    }

    // 体重を保存する
    public function store(StoreWeightRequest $request)
    {
        try {
            // チェックを通った値（weight・recorded_on）を、ログイン中のユーザーの記録として保存する
            // （user_id は自動で入る。投稿の保存と同じ仕組み）
            auth()->user()->weights()->create($request->validated());
        } catch (UniqueConstraintViolationException $e) {
            // ほぼ同時に2回送信されると、入力チェックをすり抜けた2回目を DB の UNIQUE が止める。
            // そのままだと Server Error になるので、入力チェックと同じメッセージでフォームに戻す
            return back()
                ->withErrors(['recorded_on' => 'この日の体重はすでに記録されています。'])
                ->withInput();
        }

        return redirect()->route('mypage')
            ->with('success', '体重を記録しました！');
    }
}