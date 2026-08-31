<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
    {
        Schema::table('bentuk_kegiatan', function (Blueprint $table) {
            $table->dropColumn(['nama_bentuk_kegiatan', 'sasaran', 'indikator_kerja']);
            $table->foreignId('jenis_kegiatan_id')->nullable()->after('repository_kerja_sama_id')->constrained('jenis_kegiatan');
            $table->foreignId('sasaran_kerja_id')->nullable()->after('jenis_kegiatan_id')->constrained('sasaran_kerja');
            $table->foreignId('indikator_kerja_id')->nullable()->after('sasaran_kerja_id')->constrained('indikator_kerja');
        });
    }

    public function down()
    {
        Schema::table('bentuk_kegiatan', function (Blueprint $table) {
            $table->dropForeign(['jenis_kegiatan_id']);
            $table->dropForeign(['sasaran_kerja_id']);
            $table->dropForeign(['indikator_kerja_id']);
            $table->dropColumn(['jenis_kegiatan_id', 'sasaran_kerja_id', 'indikator_kerja_id']);
            $table->string('nama_bentuk_kegiatan')->nullable();
            $table->string('sasaran')->nullable();
            $table->text('indikator_kerja')->nullable();
        });
    }
};
