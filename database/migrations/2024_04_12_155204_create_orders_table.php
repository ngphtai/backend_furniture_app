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
            $table->foreignId('user_id');
            $table->bigInteger('total_price');
            $table->json('products');
            $table->string('address');
            $table->string('phone');
            $table->string('name');
            //date order
            $table->string('type_payment');
            $table->string('status');
            $table->string('note');
            //is_done = 0: chưa xác nhận , 1: đã xác nhận, 2: đã giao hàng, 3: đã hủy
            $table->integer('is_done')->default('0');
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
