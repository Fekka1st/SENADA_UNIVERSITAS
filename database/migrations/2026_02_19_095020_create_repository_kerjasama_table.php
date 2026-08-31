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
        Schema::create('repository_kerjasama', function (Blueprint $table) {

        $table->id();
        $table->unsignedBigInteger('jenis_dokumen_id');
        $table->string('nomor_dokumen')->nullable();
        $table->string('judul_kerjasama')->nullable();
        $table->text('deskripsi')->nullable();
        $table->date('tanggal_mulai')->nullable();
        $table->date('tanggal_berakhir')->nullable();
        $table->integer('status')->nullable();
        $table->timestamps();
        $table->foreign('jenis_dokumen_id')->references('id')->on('jenis_dokumen')->onDelete('cascade');
        $table->foreignId('fakultas_id')->constrained('fakultas')->onDelete('cascade');
        $table->index(['status', 'tanggal_mulai', 'tanggal_berakhir']);

        });
    }


    public function down(): void
    {
        Schema::dropIfExists('repository_kerjasama');
    }
};
