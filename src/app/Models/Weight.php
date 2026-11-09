<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;

class Weight extends Model
{
    use HasFactory; 

    // フォームから一度に保存してよい列
    protected $fillable = [
        'weight',
        'recorded_on',
    ];

    // この体重を記録したユーザー（記録は1人のユーザーに属する）
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}