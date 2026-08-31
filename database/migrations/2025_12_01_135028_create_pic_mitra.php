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
        Schema::create('pic_mitra', function (Blueprint $table) {
            $table->id();
            $table->string('nama_pic');
            $table->string('alamat');
            $table->char('no_telp',20);
            $table->string('jabatan');
            $table->string('email');
            $table->integer('status_pic');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pic_mitra');
    }
};
