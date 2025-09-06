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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete(); // Связь с заказом
            $table->foreignId('souvenir_id')->constrained('souvenirs')->cascadeOnDelete(); // Связь с сувениром
            $table->integer('quantity'); // Количество товара
            $table->decimal('price_at_purchase', 10, 2); // Цена товара на момент покупки
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};

