<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPhotoBlobToFoodsTable extends Migration
{
    public function up()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->longBlob('photo_blob')->nullable()->after('comment');
        });
    }

    public function down()
    {
        Schema::table('foods', function (Blueprint $table) {
            $table->dropColumn('photo_blob');
        });
    }
}
