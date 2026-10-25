<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PostFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'dish_name' => fake()->randomElement([
                '鶏むね肉のサラダ', '豆腐ハンバーグ', '野菜スープ',
                'サバの塩焼き', 'オートミール粥', 'きのこの炊き込みご飯',
            ]),
            'calories' => fake()->numberBetween(100, 800),
            'eaten_on' => fake()->dateTimeBetween('-14 days', 'now')->format('Y-m-d'),
            'image_path' => 'posts/sample.jpg',
            'memo' => fake()->optional()->realText(50),
        ];
    }
}