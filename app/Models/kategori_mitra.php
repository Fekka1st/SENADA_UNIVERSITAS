<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class kategori_mitra extends Model
{
    //
    use LogsActivity;
    protected $table = 'kategori_mitra';
    protected $fillable = [
        'nama_kategori',
        'warna_peta',
        'keterangan'
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('kategori_mitra')
            ->setDescriptionForEvent(function(string $eventName) {
                $desc = match($eventName) {
                    'created' => 'Menambah Kategori Mitra baru',
                    'updated' => 'Memperbarui data Kategori Mitra',
                    'deleted' => 'Menghapus Kategori Mitra',
                    default   => "Melakukan {$eventName} pada Master Kategori"
                };
                return $desc;
            }
        );
    }

    public function partners(): HasMany
    {
        return $this->hasMany(mitra::class, 'kategori_id');
    }
}
