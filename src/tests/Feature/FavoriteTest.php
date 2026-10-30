<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FavoriteTest extends TestCase
{
    use RefreshDatabase;

    public function test_お気に入りを登録して解除できる(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->create();

        // 1回目：登録される
        $this->actingAs($user)
            ->postJson(route('posts.favorite', $post))
            ->assertOk()
            ->assertJson(['favorited' => true, 'count' => 1]);

        // 2回目：解除される
        $this->actingAs($user)
            ->postJson(route('posts.favorite', $post))
            ->assertOk()
            ->assertJson(['favorited' => false, 'count' => 0]);
    }

    public function test_ログインしていないとお気に入りできない(): void
    {
        $post = Post::factory()->create();

        $this->postJson(route('posts.favorite', $post))
            ->assertUnauthorized();   // 401

        $this->assertDatabaseCount('favorites', 0);
    }
}