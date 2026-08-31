<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KerjasamaFile extends Model
{
    //
    protected $table = 'kerjasama_file';

    protected $fillable = [
        'kerjasama_id',
        'nama_file',
        'file_path',
        'type_file',
        'size',
    ];

    public function kerjasama()
    {
        return $this->belongsTo(Kerjasama::class, 'kerjasama_id');
    }
}
