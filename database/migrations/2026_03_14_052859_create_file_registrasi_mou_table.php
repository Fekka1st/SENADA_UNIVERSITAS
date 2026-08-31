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
        Schema::create('file_registrasi_mou', function (Blueprint $table) {
            $table->id();
            $table->foreignId('registrasimou_id')->constrained('registrasi_mou')->onDelete('cascade');
            $table->string('nama_file');
            $table->string('file_path');
            $table->string('type_file', 10);
            $table->integer('size');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('file_registrasi_mou');
    }
};
