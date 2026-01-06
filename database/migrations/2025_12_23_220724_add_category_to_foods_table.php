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
    public function up(): void
{
    Schema::table('foods', function (Blueprint $table) {
        $table->json('category')->nullable()->after('name'); // JSON形式で保存
    });
}

public function down(): void
{
    Schema::table('foods', function (Blueprint $table) {
        $table->dropColumn('category');
    });
}

};
