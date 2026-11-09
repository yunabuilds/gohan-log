<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration

{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('weights', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->decimal('weight', 4, 1);   // 体重（kg・小数第1位まで）
        $table->date('recorded_on');       // 記録した日
        $table->timestamps();

        // 同じ人が同じ日に2回記録できないようにする
        $table->unique(['user_id', 'recorded_on']);
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weights');
    }
};
