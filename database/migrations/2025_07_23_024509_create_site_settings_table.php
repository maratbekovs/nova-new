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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique(); // Уникальный ключ настройки (например, 'about_us_text', 'phone_number')
            $table->text('value')->nullable(); // Значение настройки
            $table->string('description')->nullable(); // Описание для админ-панели
            $table->string('type')->default('text'); // Тип поля (text, textarea, image, etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};

