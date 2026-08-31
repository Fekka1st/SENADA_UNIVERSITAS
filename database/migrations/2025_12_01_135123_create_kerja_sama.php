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
            Schema::create('kerja_sama', function (Blueprint $table) {
            $table->id();

            $table->foreignId('jenis_id')->constrained('jenis_dokumen')->onDelete('cascade');
            $table->foreignId('mitra_id')->constrained('mitra')->onDelete('cascade');
            $table->foreignId('fakultas_id')->constrained('fakultas')->onDelete('cascade');
            $table->foreignId('prodi_id')->constrained('prodi')->onDelete('cascade');

            // Identitas Dokumen
            $table->string('kode_dokumen')->unique(); // Akan diisi: MoU/2026/001
            $table->string('judul_kerjasama');
            $table->text('deskripsi')->nullable();

            // Masa Berlaku
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai');

            // Status & Verifikasi
            $table->integer('status_kerjasama')->default(0); // 0: Draft, 1: Pending, 2: Diterima 3:Revisi/Ditolak
            $table->string('catatan_revisi')->nullable();
            $table->date('tanggal_verifikasi')->nullable();

            // Relasi ke User (Pengaju)
            $table->foreignId('nama_pengajuan')
                ->nullable()
                ->constrained('users')
                ->onDelete('set null');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kerja_sama');
    }
};
