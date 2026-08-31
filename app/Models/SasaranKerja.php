<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SasaranKerja extends Model
{
    //
    use HasFactory;

    protected $table = 'sasaran_kerja';

    protected $fillable = [
        'nama_sasaran',
        'keterangan',
    ];

    public function indikatorKerja(): HasMany
    {
        return $this->hasMany(IndikatorKerja::class, 'sasaran_kerja_id');
    }

    public function bentukKegiatans(): HasMany
    {
        return $this->hasMany(BentukKegiatan::class, 'sasaran_kerja_id');
    }
}
