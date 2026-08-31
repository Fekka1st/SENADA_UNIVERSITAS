<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class Fakultas extends Model
{
    use LogsActivity;

    protected $table = 'fakultas';

    protected $fillable = [
        'nama_fakultas',
        'akreditasi_fakultas',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('fakultas')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Menambah data fakultas baru',
                'updated' => 'Memperbarui data fakultas',
                'deleted' => 'Menghapus data fakultas',
                default   => "Melakukan {$eventName} pada data fakultas"
            });
    }

    public function prodis(): HasMany
    {
        return $this->hasMany(prodi::class, 'fakultas_id');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'fakultas_id');
    }
    public function kerjaSamas(): HasMany
    {
        return $this->hasMany(kerjasama::class, 'fakultas_id');
    }
}
