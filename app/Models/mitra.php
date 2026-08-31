<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;

class mitra extends Model
{
    //

    use LogsActivity;
    protected $table = 'mitra';

    protected $fillable = [
        'nama_mitra',
        'kategori_id',
        'negara',
        'alamat_lengkap',
        'latitude',
        'longtitude',
        'url_website',

    ];

    public function kategori(): BelongsTo
    {
        return $this->belongsTo(kategori_mitra::class, 'kategori_id');
    }

    public function pics()
    {
        return $this->hasMany(PicMitra::class, 'mitra_id');
    }


    public function picUtama() // helper
    {
        return $this->hasOne(PicMitra::class, 'mitra_id')->where('status_pic', 1);
    }

    public function kerjaSamas(): HasMany
    {
        return $this->hasMany(KerjaSama::class, 'mitra_id');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->useLogName('mitra')
            ->setDescriptionForEvent(function(string $eventName) {
                $nama = $this->nama_mitra ?? 'Sistem';
                return match($eventName) {
                    'created' => "Mendaftarkan mitra baru: **{$nama}**",
                    'updated' => "Memperbarui informasi data mitra: **{$nama}**",
                    'deleted' => "Menghapus data mitra: **{$nama}**",
                    default   => "Melakukan {$eventName} pada mitra: **{$nama}**",
                };
            });
    }

    
}
