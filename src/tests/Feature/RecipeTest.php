<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class RecipeTest extends TestCase
{
    use RefreshDatabase;

    // レシピを書いて投稿すると、保存されて詳細に表示される
    public function test_レシピを書いて投稿すると詳細に表示される(): void
    {
        Storage::fake('public');
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('posts.store'), [
            'image' => UploadedFile::fake()->image('food.jpg'),
            'dish_name' => 'サラダチキン',
            'calories' => 200,
            'eaten_on' => '2026-11-05',
            'ingredients' => '鶏むね肉 200g',
            'steps' => '鶏むね肉をゆでる',
        ]);

        $post = Post::first();
        $response->assertRedirect(route('posts.show', $post));

        $this->assertDatabaseHas('posts', [
            'id' => $post->id,
            'ingredients' => '鶏むね肉 200g',
            'steps' => '鶏むね肉をゆでる',
        ]);

        $this->get(route('posts.show', $post))
            ->assertSee('材料')
            ->assertSee('鶏むね肉 200g')
            ->assertSee('作り方')
            ->assertSee('鶏むね肉をゆでる');
    }

    // 編集画面にレシピが入っていて、そのまま更新してもレシピが消えない
    public function test_編集画面にレシピが入っている(): void
    {
        $user = User::factory()->create();
        $post = Post::factory()->for($user)->create([
            'ingredients' => '鶏むね肉 200g',
            'steps' => '鶏むね肉をゆでる',
        ]);

        $this->actingAs($user)->get(route('posts.edit', $post))
            ->assertOk()
            ->assertSee('鶏むね肉 200g')
            ->assertSee('鶏むね肉をゆでる');
    }

    // レシピがない投稿は、詳細に「材料」「作り方」が出ない
    public function test_レシピがない投稿は詳細に見出しが出ない(): void
    {
        $post = Post::factory()->create([
            'ingredients' => null,
            'steps' => null,
        ]);

        $this->get(route('posts.show', $post))
            ->assertOk()
            ->assertDontSee('材料')
            ->assertDontSee('作り方');
    }
}