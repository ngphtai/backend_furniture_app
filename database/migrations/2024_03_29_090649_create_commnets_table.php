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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // constraint là ràng buộc nếu user_id bị xóa thì comment cũng bị xóa theo(cascade)
            $table->foreignId('order_id');
            $table->foreignId('product_id');
            $table->double('rating', 2, 1); // 2 số trước dấu phẩy, 1 số sau dấu phẩy
            $table->text('content');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
