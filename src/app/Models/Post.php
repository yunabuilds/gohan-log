<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;   // ← 足した
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;   // ← 足した

    // フォームから一度に保存してよい列
    protected $fillable = [
        'user_id',
        'dish_name',
        'calories',
        'eaten_on',
        'image_path',
        'memo',
        'ingredients',
        'steps',
    ];

    // この投稿を書いたユーザー（投稿は1人のユーザーに属する）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // この投稿についたお気に入り
    public function favorites()
    {
        return $this->hasMany(Favorite::class);
    }
}