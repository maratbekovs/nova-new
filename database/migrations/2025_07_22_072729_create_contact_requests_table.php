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
        Schema::create('contact_requests', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Имя отправителя
            $table->string('email'); // Email отправителя
            $table->string('phone')->nullable(); // Телефон отправителя (опционально)
            $table->text('message')->nullable(); // Сообщение
            $table->string('type')->nullable(); // Тип запроса (например, 'tour_inquiry', 'newsletter', 'contact_form')
            $table->boolean('is_read')->default(false); // Прочитан ли запрос
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_requests');
    }
};

