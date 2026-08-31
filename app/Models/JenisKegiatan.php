<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisKegiatan extends Model
{

    use HasFactory;
    protected $table = 'jenis_kegiatan';

    protected $fillable = [
        'nama_kegiatan',
        'keterangan',
    ];

    public function bentukKegiatans(): HasMany
    {
        return $this->hasMany(BentukKegiatan::class, 'jenis_kegiatan_id');
    }
}
