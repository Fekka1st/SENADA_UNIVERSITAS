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
        Schema::create('ruanglingkup_mitra', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kerjasama_id')->constrained('kerja_sama')->onDelete('cascade');
            $table->foreignId('ruanglingkup_id')->constrained('ruanglingkup')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ruanglingkup_mitra');
    }
};
