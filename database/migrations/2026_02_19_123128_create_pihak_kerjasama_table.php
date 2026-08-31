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
        Schema::create('pihak_kerjasama', function (Blueprint $table) {
            $table->id();
            $table->string('nama_penandatangan');
            $table->string('jabatan_penandatangan');
            $table->string('nama_penanggungjawab')->nullable();
            $table->string('jabatan_penanggungjawab')->nullable();
            $table->integer('urutan_pihak');
            $table->foreignId('mitra_id')->constrained('mitra')->onDelete('cascade');
            $table->foreignId('repository_id')->constrained('repository_kerjasama')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pihak_kerjasama');
    }
};
