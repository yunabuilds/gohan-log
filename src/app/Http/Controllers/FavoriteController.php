<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class FavoriteController extends Controller
{
    // お気に入りの登録・解除を切り替えて、JSON を返す
    public function toggle(Request $request, Post $post)
    {
        $user = $request->user();

        // この人がこの投稿をもうお気に入りしているか探す
        $favorite = $post->favorites()->where('user_id', $user->id)->first();

        if ($favorite) {
            $favorite->delete();                                  // していたら → 解除
            $favorited = false;
        } else {
            $post->favorites()->create(['user_id' => $user->id]); // していなければ → 登録
            $favorited = true;
        }

        // 画面ではなく、データ（JSON）だけを返す
        return response()->json([
            'favorited' => $favorited,
            'count' => $post->favorites()->count(),
        ]);
    }
}