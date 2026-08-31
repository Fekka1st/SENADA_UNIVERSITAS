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
        Schema::create('mitra', function (Blueprint $table) {
            $table->id();
            $table->string('nama_mitra');
            $table->string('negara');
            $table->string('alamat_lengkap');
            $table->string('latitude');
            $table->string('longtitude');
            $table->string('url_website')->nullable();
            $table->foreignId('kategori_id')->constrained('kategori_mitra')->onDelete('cascade');
            $table->foreignId('pic_id')->constrained('pic_mitra')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mitra');
    }
};
