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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->string('author_name'); // Имя автора отзыва
            $table->text('text'); // Текст отзыва
            $table->integer('rating')->unsigned()->default(5); // Рейтинг от 1 до 5
            $table->morphs('reviewable'); // Полиморфная связь для Tour или Souvenir
            $table->boolean('is_approved')->default(false); // Флаг для премодерации
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};

