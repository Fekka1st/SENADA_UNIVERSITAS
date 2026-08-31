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
        Schema::create('bentuk_kegiatan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('repository_kerja_sama_id')->constrained('repository_kerjasama')->onDelete('cascade');
            $table->string('nama_bentuk_kegiatan');
            $table->decimal('nilai_kontrak', 15, 2)->default(0);
            $table->text('luaran')->nullable();
            $table->string('sasaran')->nullable();
            $table->text('indikator_kerja')->nullable();
            $table->text('keterangan')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bentuk_kegiatan');
    }
};
