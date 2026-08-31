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
        Schema::create('pengaturan', function (Blueprint $table) {
            $table->unsignedInteger('id_pengaturan')->primary();
            $table->string('nama_aplikasi');
            $table->string('kepanjangan_aplikasi');
            $table->string('nama_copyright');
            $table->string('logo_instnasi')->nullable();
            $table->string('favicon')->nullable();
            $table->string('background_login')->nullable();
            $table->string('tema_warna_utama')->default('#14438B');
            $table->string('sosmed_facebook')->nullable();
            $table->string('sosmed_twitter')->nullable();
            $table->string('sosmed_instagram')->nullable();
            $table->string('sosmed_youtube')->nullable();
            $table->string('sosmed_tiktok')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengaturan');
    }
};
