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
        Schema::create('tours', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название тура
            $table->text('description')->nullable(); // Описание тура
            $table->decimal('price', 10, 2); // Цена тура
            $table->decimal('discount_price', 10, 2)->nullable(); // Цена со скидкой (опционально)
            $table->integer('duration_days'); // Продолжительность в днях
            $table->integer('duration_nights'); // Продолжительность в ночах
            $table->string('country'); // Страна
            $table->string('city'); // Город
            $table->foreignId('tour_type_id')->constrained('tour_types')->cascadeOnDelete(); // Связь с TourType
            $table->decimal('rating', 2, 1)->nullable(); // Рейтинг (например, 4.5)
            $table->string('image_url')->nullable(); // URL изображения тура
            $table->boolean('is_active')->default(true); // Активен ли тур
            $table->boolean('is_featured')->default(false); // Флаг "Хит"
            $table->boolean('is_discounted')->default(false); // Флаг "Скидка"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tours');
    }
};

