<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Data_MoU extends Model
{
    use HasFactory;

    // Nama tabel disesuaikan dengan migrasi terakhir kita
    protected $table = 'registrasi_mou';

    protected $fillable = [
        'user_id',
        'mitra_id',
        'rencana_id', // Link opsional ke tahap rencana
        'nomor_mou',
        'kode_berkas',
        'judul_mou',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status_mou',
    ];


    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_berakhir' => 'date',
    ];



    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }


    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }


    public function rencana()
    {
        return $this->belongsTo(RencanaKerjasama::class, 'rencana_id');
    }


    // public function moas()
    // {
    //     return $this->hasMany(RegistrasiMoa::class, 'mou_id');
    // }


    public function getIsActiveAttribute()
    {
        return now()->between($this->tanggal_mulai, $this->tanggal_berakhir);
    }


    public function getSisaHariAttribute()
    {
        if (now()->gt($this->tanggal_berakhir)) {
            return 0;
        }
        return now()->diffInDays($this->tanggal_berakhir);
    }
}
