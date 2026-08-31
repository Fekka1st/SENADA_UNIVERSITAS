<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RencanaKerjasama extends Model
{
    //

    use HasFactory;
    protected $table = 'pengajuan_rencana';

    protected $fillable = [
        'user_id',
        'mitra_id',
        'ruanglingkup_id',
        'prodi_id',
        'fakultas_id',
        'judul_rencana',
        'deskripsi',
        'feedback_internal',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
    public function ruangLingkup()
    {
        return $this->belongsTo(RuangLingkup::class, 'ruanglingkup_id');
    }
    public function files()
    {
        return $this->hasMany(FileRencanaKerjasama::class, 'pengajuanrencana_id');
    }
    public function mou()
    {
        return $this->hasOne(berkas_mou::class, 'rencana_id');
    }
}
