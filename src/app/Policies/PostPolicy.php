<?php

namespace App\Policies;

use App\Models\Post;
use App\Models\User;

class PostPolicy
{
    // 編集・更新：自分の投稿だけ
    public function update(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }

    // 削除：自分の投稿だけ
    public function delete(User $user, Post $post): bool
    {
        return $user->id === $post->user_id;
    }
}