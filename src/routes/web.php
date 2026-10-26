<?php

use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// トップは投稿一覧へ
Route::get('/', function () {
    return redirect()->route('posts.index');
});

// Breeze のダッシュボード（ナビゲーションが使っているので残す）
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ログインが必要なルート
Route::middleware('auth')->group(function () {
    // Breeze のプロフィール（そのまま残す）
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // 投稿：作成・保存・編集・更新・削除
    Route::resource('posts', PostController::class)->except(['index', 'show']);
});

// ログインが不要なルート：投稿の一覧・詳細
Route::resource('posts', PostController::class)->only(['index', 'show']);

require __DIR__.'/auth.php';