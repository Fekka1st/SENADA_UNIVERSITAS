<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class kerjasama extends Model
{
    protected $table = 'kerja_sama';
    protected $fillable = [
        'mitra_id',
        'kode_dokumen',
        'jenis_id',
        'judul_kerjasama',
        'tanggal_mulai',
        'tanggal_selesai',
        'prodi_id',
        'fakultas_id',
        'deskripsi',
        'status_kerjasama', // 0:Draft, 1:Pending, 2:Revisi, 3:Aktif, 4:Kadaluarsa
        'tanggal_verifikasi',
        'nama_pengajuan', // ID Operator yang menginput atau id user
        'catatan_revisi', // Digunakan jika status adalah Revisi
    ];

    protected $casts = [
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
    ];

    public function mitra()
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'nama_pengajuan');
    }

    public function getStatusLabelAttribute()
    {
        return match($this->status) {
            0 => '<span class="badge bg-secondary">Draft</span>',
            1 => '<span class="badge bg-info text-white">Pending</span>',
            2 => '<span class="badge bg-warning text-dark">Revisi</span>',
            3 => '<span class="badge bg-success">Aktif</span>',
            4 => '<span class="badge bg-danger">Kadaluarsa</span>',
            default => '<span class="badge bg-light text-dark">Unknown</span>',
        };
    }

    public function getIsExpiredAttribute()
    {
        return Carbon::today()->gt($this->tgl_berakhir);
    }


    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(fakultas::class, 'fakultas_id');
    }

    public function files(): HasMany
    {
        // Parameter kedua adalah foreign key di tabel kerja_sama_file
        return $this->hasMany(KerjasamaFile::class, 'kerjasama_id');
    }
}
