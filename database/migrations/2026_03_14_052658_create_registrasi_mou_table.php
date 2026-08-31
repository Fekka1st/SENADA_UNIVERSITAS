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
        Schema::create('registrasi_mou', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rencana_id')->nullable()->constrained('pengajuan_rencana')->onDelete('set null');
            $table->foreignId('mitra_id')->constrained('mitra');
            $table->foreignId('user_id')->constrained('users');
            $table->string('nomor_berkas_mou')->nullable()->unique();

            // $table->string('kode_berkas')->unique();
            $table->string('judul_mou');
            $table->text('deskripsi_singkat')->nullable();
            // Masa Berlaku
            $table->date('tanggal_mulai')->nullable();
            $table->date('tanggal_berakhir')->nullable();
            $table->integer('usulan_durasi_tahun')->nullable()->comment('Usulan durasi dalam tahun, untuk perhitungan otomatis');

            $table->tinyInteger('status_mou')->default(1); // 1: Aktif, 2: Expired
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrasi_mou');
    }
};
