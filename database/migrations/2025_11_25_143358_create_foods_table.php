<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('name');         
            $table->string('genre')->nullable();
            $table->string('store_name')->nullable();
            $table->integer('price')->nullable();
            $table->tinyInteger('rating')->nullable();
            $table->text('comment')->nullable();
            $table->string('photo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
      public function down(): void
    {
        Schema::dropIfExists('foods');
    }
};
