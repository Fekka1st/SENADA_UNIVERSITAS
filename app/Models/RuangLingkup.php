<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class RuangLingkup extends Model
{
    //
    use LogsActivity;
    protected $table = 'ruanglingkup';
    protected $fillable = [
        'nama_ruanglingkup',
        'keterangan'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('ruanglingkup')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Menambah Ruang Lingkup baru',
                'updated' => 'Memperbarui data Ruang Lingkup',
                'deleted' => 'Menghapus Ruang Lingkup',
                default   => "Melakukan {$eventName} pada master Ruang Lingkup"
            });
    }

    public function ruanglingkup_mitra(): HasMany
    {
        return $this->hasMany(ruanglingkup_mitra::class, 'ruanglingkup_id');
    }

    public function kerjaSamas(): BelongsToMany
    {
        return $this->belongsToMany(
            KerjaSama::class,
            'ruanglingkup_mitra',
            'ruanglingkup_id',
            'kerjasama_id'
        );
    }


}
