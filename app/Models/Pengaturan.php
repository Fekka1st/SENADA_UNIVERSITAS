<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengaturan extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'pengaturan';

    protected $primaryKey = 'id_pengaturan';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nama_aplikasi',
        'kepanjangan_aplikasi',
        'nama_copyright',
        'logo_instnasi',
        'favicon',
        'background_login',
        'tema_warna_utama',
        'sosmed_facebook',
        'sosmed_twitter',
        'sosmed_instagram',
        'sosmed_youtube',
        'sosmed_tiktok',
    ];
}
