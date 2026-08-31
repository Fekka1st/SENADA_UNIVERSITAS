<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class berkas_moa extends Model
{
    //
    protected $table = 'registrasi_moa';
    protected $fillable = [
        'mou_id',
        'user_id',
        'ruanglingkup_id',
        'nomor_moa',
        'judul_moa',
        'kode_berkas',
        'tanggal_mulai',
        'tanggal_berakhir',
        'tujuan_moa',
        'peran_tanggung_jawab',
        'nominal_finansial',
        'sumber_dana',
        'deskripsi'
    ];

    public function mou()
    {
        return $this->belongsTo(berkas_mou::class, 'mou_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ruangLingkup()
    {
        return $this->belongsTo(RuangLingkup::class, 'ruanglingkup_id');
    }

    public function files()
    {
        return $this->hasMany(file_berkas_moa::class, 'registrasi_moa_id');
    }
}
