<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class jenis_dokumen extends Model
{
    //
    use LogsActivity;
    protected $table = 'jenis_dokumen';
    protected $fillable = [
        'kode_inisial',
        'nama_jenis',
        'keterangan',
    ];

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('jenis_dokumen')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Menambah jenis dokumen baru',
                'updated' => 'Memperbarui data jenis dokumen',
                'deleted' => 'Menghapus jenis dokumen',
                default   => "Melakukan {$eventName} pada master jenis dokumen"
            });
    }

    public function kerjaSamas(): HasMany
    {
        return $this->hasMany(KerjaSama::class, 'jenis_id');
    }
}
