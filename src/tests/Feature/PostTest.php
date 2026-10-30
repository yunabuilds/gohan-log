<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostTest extends TestCase
{
    // テストのたびに DB を空にしてから始める
    use RefreshDatabase;

    public function test_ログインしたユーザーは写真付きで投稿できる(): void
    {
        // 本物の倉庫の代わりに、テスト用の「にせの倉庫」を使う
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'image' => UploadedFile::fake()->image('latte.jpg'),   // にせの写真
            'dish_name' => 'ラテ',
            'calories' => 300,
            'eaten_on' => '2026-10-30',
            'memo' => '新宿',
        ]);

        $post = Post::first();

        // 詳細画面へ移動した
        $response->assertRedirect(route('posts.show', $post));
        // DB に、ログインした人の投稿として保存された
        $this->assertDatabaseHas('posts', [
            'user_id' => $user->id,
            'dish_name' => 'ラテ',
            'calories' => 300,
        ]);
        // 写真が倉庫に保存された
        Storage::disk('public')->assertExists($post->image_path);
    }

    public function test_写真がないと投稿できない(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'dish_name' => 'ラテ',
            'calories' => 300,
            'eaten_on' => '2026-10-30',
        ]);

        // 写真のエラーが出て、DB には何も保存されない
        $response->assertSessionHasErrors('image');
        $this->assertDatabaseCount('posts', 0);
    }

    public function test_ログインしていないと投稿フォームを開けない(): void
    {
        $this->get(route('posts.create'))
            ->assertRedirect(route('login'));
    }
}