<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->json('category')->nullable();
            $table->string('store_name')->nullable();
            $table->string('price')->nullable();
            $table->integer('rating')->nullable();
            $table->text('comment')->nullable();
            $table->date('date');
            $table->json('photo_blob')->nullable(); // 画像を base64 で JSON に保存
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
