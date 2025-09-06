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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->decimal('total_amount', 10, 2); // Общая сумма заказа
            $table->string('status')->default('pending'); // Статус заказа (pending, completed, cancelled)
            $table->string('customer_name'); // Имя клиента
            $table->string('customer_email'); // Email клиента
            $table->string('customer_phone')->nullable(); // Телефон клиента (опционально)
            $table->text('shipping_address')->nullable(); // Адрес доставки (для сувениров)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};

