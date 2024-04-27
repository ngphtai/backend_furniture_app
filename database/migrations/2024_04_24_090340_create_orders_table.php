<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('user_id');
            $table->double('total_price');
            $table->json('products');
            $table->string('address');
            $table->string('phone');
            $table->string('name');
            //date order
            $table->string('type_payment');
            $table->string('status');
            $table->string('note');
            //is_done = 0: chưa xác nhận , 1: đã xác nhận, 2: đã giao hàng, 3: giao thành công, 4 yêu caauf hoàn tiền, -1 huỷ hoá đơn
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
