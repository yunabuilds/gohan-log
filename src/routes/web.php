<?php

use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\MyPageController;
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

    // マイページ（日付で絞り込み）
    Route::get('/mypage', [MyPageController::class, 'index'])->name('mypage');

    // お気に入り一覧
    Route::get('/favorites', [FavoriteController::class, 'index'])->name('favorites.index');

    // お気に入りの登録・解除（Ajax・JSON を返す）
    Route::post('/posts/{post}/favorite', [FavoriteController::class, 'toggle'])->name('posts.favorite');
});

// ログインが不要なルート：投稿の一覧・詳細
Route::resource('posts', PostController::class)->only(['index', 'show']);

require __DIR__.'/auth.php';