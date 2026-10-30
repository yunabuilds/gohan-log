<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PostPolicyTest extends TestCase
{
    use RefreshDatabase;

    public function test_自分の投稿は編集画面を開ける(): void
    {
        $owner = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($owner)
            ->get(route('posts.edit', $post))
            ->assertOk();   // 200
    }

    public function test_他の人の投稿の編集画面は403になる(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->get(route('posts.edit', $post))
            ->assertForbidden();   // 403
    }

    public function test_他の人の投稿は削除できない(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $owner->id]);

        $this->actingAs($other)
            ->delete(route('posts.destroy', $post))
            ->assertForbidden();

        // 投稿は消えずに残っている
        $this->assertDatabaseHas('posts', ['id' => $post->id]);
    }
}