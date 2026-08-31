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
        Schema::create('indikator_kerja', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sasaran_kerja_id')->constrained('sasaran_kerja')->onDelete('cascade');
            $table->string('nama_indikator');
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('indikator_kerja');
    }

};
