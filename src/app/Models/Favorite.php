<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'post_id'];

    // お気に入りしたユーザー
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // お気に入りされた投稿
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}