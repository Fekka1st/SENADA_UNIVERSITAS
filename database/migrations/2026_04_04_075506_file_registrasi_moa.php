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
        //
        Schema::create('file_registrasi_moa', function (Blueprint $table) {
            $table->id();

            // Relasi ke tabel registrasi_moa
            $table->foreignId('registrasi_moa_id')->constrained('registrasi_moa')->onDelete('cascade');

            // Data Metadata File
            $table->string('nama_file');    // Nama asli file (cth: Surat_Perjanjian_MoA.pdf)
            $table->string('file_path');    // Path di server (cth: kerjasama/moa/12345.pdf)
            $table->string('type_file', 20); // Ekstensi (cth: pdf)
            $table->bigInteger('size');     // Ukuran file dalam bytes

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
