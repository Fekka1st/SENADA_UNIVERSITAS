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
        Schema::create('file_pengajuan_rencana', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pengajuanrencana_id')->constrained('pengajuan_rencana')->onDelete('cascade');
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
        Schema::dropIfExists('file_pengajuan_rencana');
    }
};
