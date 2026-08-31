<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('sasaran_kerja', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sasaran')->comment('Contoh: Meningkatnya Kualitas Lulusan');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sasaran_kerja');
    }
};
