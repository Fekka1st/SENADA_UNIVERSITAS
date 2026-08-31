<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * Model untuk menyimpan rincian implementasi kegiatan dari sebuah kerjasama.
 */
class BentukKegiatan extends Model
{
    use LogsActivity;

    protected $table = 'bentuk_kegiatan';


   protected $fillable = [
        'repository_kerja_sama_id',
        'jenis_kegiatan_id',
        'sasaran_kerja_id',
        'indikator_kerja_id',
        'nilai_kontrak',
        'luaran',
        'keterangan',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()           // Mencatat semua kolom yang ada di $fillable
            ->logOnlyDirty()          // Hanya mencatat kolom yang datanya benar-benar berubah
            ->dontSubmitEmptyLogs()   // Jangan simpan log jika tidak ada perubahan
            ->useLogName('bentuk_kegiatan')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Menambahkan rincian bentuk kegiatan baru',
                'updated' => 'Memperbarui data rincian kegiatan',
                'deleted' => 'Menghapus rincian bentuk kegiatan',
                default   => "Melakukan {$eventName} pada data bentuk kegiatan"
            });
    }

    public function repository(): BelongsTo
    {
        return $this->belongsTo(repository_kerjasama::class, 'repository_kerja_sama_id');
    }

    public function jenisKegiatan(): BelongsTo
    {
        return $this->belongsTo(JenisKegiatan::class, 'jenis_kegiatan_id');
    }

    public function sasaranKerja(): BelongsTo
    {
        return $this->belongsTo(SasaranKerja::class, 'sasaran_kerja_id');
    }

    public function indikatorKerja(): BelongsTo
    {
        return $this->belongsTo(IndikatorKerja::class, 'indikator_kerja_id');
    }
}
