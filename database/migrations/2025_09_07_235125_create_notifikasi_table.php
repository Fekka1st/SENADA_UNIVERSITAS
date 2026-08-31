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
        Schema::create('notifikasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('jenis'); // sistem, informasi, peringatan, sukses, dll
            $table->string('judul');
            $table->text('pesan');
            $table->json('data')->nullable(); // data tambahan seperti id, url, dll
            $table->timestamp('dibaca_pada')->nullable();
            $table->timestamps();
            
            // Indexes untuk performance
            $table->index(['user_id', 'dibaca_pada']);
            $table->index(['user_id', 'created_at']);
            $table->index(['jenis']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifikasi');
    }
};
