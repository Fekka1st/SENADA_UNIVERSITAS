<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class file_repositorykerjasama extends Model
{
    use LogsActivity;
    protected $table = 'file_repository_kerjasama';
    protected $fillable = [
        'repository_id',
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
            ->useLogName('file_repository')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Mengunggah lampiran dokumen baru',
                'updated' => 'Memperbarui informasi file lampiran',
                'deleted' => 'Menghapus file lampiran',
                default   => "Melakukan {$eventName} pada file lampiran"
            });
    }


    public function repository(): BelongsTo
    {
        return $this->belongsTo(repository_kerjasama::class, 'repository_kerja_sama_id');
    }
}
