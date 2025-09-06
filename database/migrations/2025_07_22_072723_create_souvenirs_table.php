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
        Schema::create('souvenirs', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // Название сувенира
            $table->text('description')->nullable(); // Описание сувенира
            $table->decimal('price', 10, 2); // Цена сувенира
            $table->decimal('discount_price', 10, 2)->nullable(); // Цена со скидкой (опционально)
            $table->string('region')->nullable(); // Регион, откуда сувенир
            $table->foreignId('souvenir_category_id')->constrained('souvenir_categories')->cascadeOnDelete(); // Связь с SouvenirCategory
            $table->decimal('rating', 2, 1)->nullable(); // Рейтинг (например, 4.8)
            $table->string('image_url')->nullable(); // URL изображения сувенира
            $table->boolean('is_active')->default(true); // Активен ли сувенир
            $table->boolean('is_featured')->default(false); // Флаг "Хит"
            $table->boolean('is_new')->default(false); // Флаг "Новинка"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('souvenirs');
    }
};

