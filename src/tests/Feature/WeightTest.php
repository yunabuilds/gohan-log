<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class WeightTest extends TestCase
{
    use RefreshDatabase;

    // 体重を記録できて、マイページに戻る
    public function test_体重を記録できる(): void
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->post(route('weights.store'), [
            'weight' => 65.5,
            'recorded_on' => '2026-11-10',
        ]);

        $response->assertRedirect(route('mypage'));
        $this->assertDatabaseHas('weights', [
            'user_id' => $user->id,
            'weight' => 65.5,
            'recorded_on' => '2026-11-10',
        ]);
    }

    // 同じ日の2回目はエラーになり、保存されない
    public function test_同じ日の2回目はエラーになる(): void
    {
        $user = User::factory()->create();
        $user->weights()->create(['weight' => 65.5, 'recorded_on' => '2026-11-10']);

        $response = $this->actingAs($user)->post(route('weights.store'), [
            'weight' => 66.0,
            'recorded_on' => '2026-11-10',
        ]);

        $response->assertSessionHasErrors('recorded_on');
        $this->assertDatabaseCount('weights', 1);
    }

    // 他の人が同じ日に記録していても、自分は記録できる
    public function test_他の人と同じ日でも記録できる(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $other->weights()->create(['weight' => 70.0, 'recorded_on' => '2026-11-10']);

        $response = $this->actingAs($user)->post(route('weights.store'), [
            'weight' => 65.5,
            'recorded_on' => '2026-11-10',
        ]);

        $response->assertSessionHasNoErrors();
        $this->assertDatabaseCount('weights', 2);
    }

    // 20〜300 の範囲外と、小数第2位はエラーになる
    public function test_範囲外や小数第2位はエラーになる(): void
    {
        $user = User::factory()->create();

        foreach ([10, 301, 65.55] as $weight) {
            $this->actingAs($user)->post(route('weights.store'), [
                'weight' => $weight,
                'recorded_on' => '2026-11-10',
            ])->assertSessionHasErrors('weight');
        }

        $this->assertDatabaseCount('weights', 0);
    }

    // マイページには自分の記録だけが出る
    public function test_マイページには自分の体重だけ表示される(): void
    {
        $user = User::factory()->create();
        $other = User::factory()->create();
        $user->weights()->create(['weight' => 65.5, 'recorded_on' => '2026-11-10']);
        $other->weights()->create(['weight' => 80.5, 'recorded_on' => '2026-11-10']);

        $this->actingAs($user)->get(route('mypage'))
            ->assertOk()
            ->assertSee('65.5 kg')
            ->assertDontSee('80.5 kg');
    }

    // ログインしていないと、記録フォームを開けない
    public function test_ログインしていないと記録フォームを開けない(): void
    {
        $this->get(route('weights.create'))
            ->assertRedirect(route('login'));
    }
}