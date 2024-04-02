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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('product_name');
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('promotion_id')->nullable()->onDelete('set null');
            $table->integer('rating_count')->default(0);
            $table->json('product_image')->nullable();
            $table->text('description')->nullable();
            $table->integer('quantity');
            $table->decimal('price', 8, 2);// decimal là kiểu số
            $table->integer('sold')->default(0);
            $table->boolean('is_show')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

