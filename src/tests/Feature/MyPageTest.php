<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyPageTest extends TestCase
{
    use RefreshDatabase;

    // 選んだ日の、自分の投稿のカロリーだけが合計される
    public function test_選んだ日の自分の投稿だけ合計カロリーに入る(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();

        // 自分の投稿：10/26 に 300 と 200
        Post::factory()->for($user)->create(['eaten_on' => '2026-10-26', 'calories' => 300]);
        Post::factory()->for($user)->create(['eaten_on' => '2026-10-26', 'calories' => 200]);

        // 足してはいけないもの：自分の別の日の投稿と、他の人の同じ日の投稿
        Post::factory()->for($user)->create(['eaten_on' => '2026-10-27', 'calories' => 999]);
        Post::factory()->for($other)->create(['eaten_on' => '2026-10-26', 'calories' => 1000]);

        $response = $this->actingAs($user)->get(route('mypage', ['date' => '2026-10-26']));

        $response->assertOk();
        $response->assertSee('合計：500 kcal');
    }

    // 投稿がない日は 0 kcal と表示される
    public function test_投稿がない日は合計が0kcalになる(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('mypage', ['date' => '2026-10-26']));

        $response->assertOk();
        $response->assertSee('合計：0 kcal');
    }
}