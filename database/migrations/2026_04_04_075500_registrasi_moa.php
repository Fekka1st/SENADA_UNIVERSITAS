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
        Schema::create('registrasi_moa', function (Blueprint $table) {
            $table->id();

            // RELASI
            $table->foreignId('mou_id')->constrained('registrasi_mou')->onDelete('cascade');
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('mitra_id')->constrained('mitra');
            $table->foreignId('ruanglingkup_id')->nullable()->constrained('ruanglingkup');

            // IDENTITAS DOKUMEN
            $table->string('nomor_moa')->unique();
            $table->string('judul_moa');
            $table->text('tujuan_moa')->nullable()->comment('Target/Outcome yang ingin dicapai');
            $table->tinyInteger('status_moa')->default(0); // 0: Draft, 1: Menunggu Admin, 2: Menunggu Pimpinan, 3: Aktif, 4: Revisi
            $table->text('catatan_revisi')->nullable(); // Catatan jika ditolak oleh Admin/Pimpinan
            // MASA BERLAKU
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->tinyInteger('usulan_durasi_tahun');

            $table->string('pejabat_penandatangan', 150)->nullable();
            $table->bigInteger('nominal_finansial')->nullable()->comment('Nilai kontrak/pembiayaan kerjasama');
            $table->string('sumber_dana', 100)->nullable()->comment('Contoh: DIPA Universitas, Hibah Dikti, Mandiri Mitra');
            $table->text('deskripsi')->nullable()->comment('Catatan tambahan lainnya');
            $table->string('file_moa_final', 255)->nullable();
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
