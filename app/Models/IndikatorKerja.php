<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class IndikatorKerja extends Model
{
    //
    use HasFactory;

    protected $table = 'indikator_kerja';

    protected $fillable = [
        'sasaran_kerja_id',
        'nama_indikator',
        'keterangan',
    ];


    public function sasaranKerja(): BelongsTo
    {
        return $this->belongsTo(SasaranKerja::class, 'sasaran_kerja_id');
    }


    public function bentukKegiatans(): HasMany
    {
        return $this->hasMany(BentukKegiatan::class, 'indikator_kerja_id');
    }
}
