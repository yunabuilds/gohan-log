<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MyPageController extends Controller
{
    public function index(Request $request)
    {
        // 日付が変な値（2026-99-99 など）のときはエラーで戻す
        $request->validate([
            'date' => 'nullable|date',
        ]);

        // 日付の指定がないときは今日
        $date = $request->filled('date') ? $request->input('date') : now()->toDateString();

        // 自分の投稿のうち、その日に食べたものだけ
        $posts = $request->user()->posts()
            ->with('user')             
            ->withCount('favorites')
            ->whereDate('eaten_on', $date)
            ->latest()
            ->get();

        return view('mypage', compact('posts', 'date'));
    }
}