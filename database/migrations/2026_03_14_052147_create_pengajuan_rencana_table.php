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
        Schema::create('pengajuan_rencana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('prodi_id')->constrained('prodi');
            $table->foreignId('fakultas_id')->constrained('fakultas');
            $table->foreignId('mitra_id')->constrained('mitra');
            $table->foreignId('ruanglingkup_id')->constrained('ruanglingkup');
            $table->string('judul_rencana');
            $table->text('deskripsi');
            $table->text('feedback_internal')->nullable(); // Catatan: "Ini menarik" atau "Jangan lanjut"
            $table->integer('status')->default(1); // 0: Draft 1:Proses Review 2: disetujui 3:ditolak 4: Revisi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_rencana');
    }
};
