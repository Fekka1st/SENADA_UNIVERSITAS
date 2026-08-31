<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class prodi extends Model
{

    use LogsActivity;
    protected $table = 'prodi';
    protected $fillable = [
        'nama_prodi',
        'akreditasi_prodi',
        'fakultas_id',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('prodi')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Menambah Program Studi baru',
                'updated' => 'Memperbarui data Program Studi',
                'deleted' => 'Menghapus Program Studi',
                default   => "Melakukan {$eventName} pada data Prodi"
            });
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }
}
