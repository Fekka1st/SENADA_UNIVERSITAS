<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('pic_mitra', function (Blueprint $table) {
            $table->unsignedBigInteger('mitra_id')->after('id')->nullable();
            $table->foreign('mitra_id')
                ->references('id')
                ->on('mitra')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('pic_mitra', function (Blueprint $table) {
            $table->dropForeign(['mitra_id']);
            $table->dropColumn('mitra_id');
        });
    }
};
