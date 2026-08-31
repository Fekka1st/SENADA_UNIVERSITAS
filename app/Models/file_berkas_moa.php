<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;

class file_berkas_moa extends Model
{
    //

    protected $table = 'file_registrasi_moa';
    protected $fillable = [
        'registrasi_moa_id',
        'nama_file',
        'file_path',
        'type_file',
        'size',
    ];


    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('file_registrasimou')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Mengunggah lampiran dokumen baru',
                'updated' => 'Memperbarui informasi file lampiran',
                'deleted' => 'Menghapus file lampiran',
                default   => "Melakukan {$eventName} pada file lampiran"
            });
    }


    public function berkas_mou(): BelongsTo
    {
        return $this->belongsTo(berkas_moa::class, 'registrasi_moa_id');
    }
}
