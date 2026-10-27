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
    Schema::create('posts', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->onDelete('cascade');
        $table->string('dish_name', 100);
        $table->unsignedInteger('calories');
        $table->date('eaten_on');
        $table->string('image_path');
        $table->text('memo')->nullable();
        $table->text('ingredients')->nullable();
        $table->text('steps')->nullable();
        $table->timestamps();

        // マイページの日付の絞り込み・合計カロリー用
        $table->index(['user_id', 'eaten_on']);
        // 一覧を新しい順に並べる用
        $table->index('created_at');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
