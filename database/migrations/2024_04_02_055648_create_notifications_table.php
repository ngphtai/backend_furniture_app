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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id') -> foreign() -> references('id') -> on('users') -> onDelete('cascade'); //on delete cascade khi user bị xóa thì notification cũng bị xóa và onUpdate cũng tương tự
            $table->string('title') ;
            $table->string('content')  ;
            $table->boolean('is_read')->default(false);
            $table->string('type');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
