<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
   public function run(): void
{
    // ダミーのユーザーを3人作り、1人5件ずつ投稿を作る（合計15件）
    User::factory(3)->create()->each(function ($user) {
        Post::factory(5)->create(['user_id' => $user->id]);
    });
}
}
