<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class repository_kerjasama extends Model
{
    protected $table = 'repository_kerjasama';
    use LogsActivity;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'jenis_dokumen_id',
        'fakultas_id',
        'nomor_dokumen',
        'judul_kerjasama',
        'deskripsi',
        'tanggal_mulai',
        'tanggal_berakhir',
        'status',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('repository_kerjasama')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Menambah data kerjasama baru',
                'updated' => 'Memperbarui informasi kerjasama',
                'deleted' => 'Menghapus arsip kerjasama',
                default   => "Melakukan {$eventName} pada data repository"
            });
    }

    public function pihakTerlibat(): HasMany
    {
        return $this->hasMany(pihakerjasama::class, 'repository_id')->orderBy('urutan_pihak', 'asc');
    }

    public function bentukKegiatan(): HasMany
    {

        return $this->hasMany(BentukKegiatan::class, 'repository_kerja_sama_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(file_repositorykerjasama::class, 'repository_kerja_sama_id');
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function jenisDokumen(): BelongsTo
    {
        return $this->belongsTo(jenis_dokumen::class, 'jenis_dokumen_id');
    }


}
