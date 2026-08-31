<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class PicMitra extends Model
{
    //
    use LogsActivity;


    protected $table = 'pic_mitra';

    protected $fillable = [
        'mitra_id',
        'nama_pic',
        'alamat',
        'no_telp',
        'jabatan',
        'email',
        'status_pic', // 1 untuk Utama, 0 untuk Pendamping
    ];

    public function mitra() : BelongsTo
    {
        return $this->belongsTo(Mitra::class, 'mitra_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('pic_mitra')
            ->setDescriptionForEvent(fn(string $eventName) => match($eventName) {
                'created' => 'Menambahkan data PIC mitra baru',
                'updated' => 'Memperbarui informasi PIC mitra',
                'deleted' => 'Menghapus data PIC mitra',
                default   => "Melakukan {$eventName} pada data PIC"
            });
    }

    public function scopePrimary($query)
    {
        return $query->where('status_pic', 1);
    }
}
