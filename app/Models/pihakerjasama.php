<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class pihakerjasama extends Model
{
    //
    use LogsActivity;

    protected $table = 'pihak_kerjasama';

    protected $fillable = [
        'repository_id',
        'mitra_id',
        'nama_penandatangan',
        'jabatan_penandatangan',
        'nama_penanggungjawab',
        'jabatan_penanggungjawab',
        'urutan_pihak'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('pihak_kerjasama')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Menambahkan pihak terlibat dalam kerjasama',
                'updated' => 'Memperbarui data perwakilan mitra',
                'deleted' => 'Menghapus pihak dari kerjasama',
                default   => "Melakukan {$eventName} pada data pihak terlibat"
            });
    }

    public function repository(): BelongsTo
    {
        return $this->belongsTo(repository_kerjasama::class, 'repository_id');
    }

    public function mitra(): BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }
}
