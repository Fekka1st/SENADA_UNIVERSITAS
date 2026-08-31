<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FileRencanaKerjasama extends Model
{
    //
    protected $table = 'file_pengajuan_rencana';
    protected $fillable = [
        'pengajuanrencana_id',
        'nama_file',
        'file_path',
        'type_file',
        'size',
    ];

    public function pengajuanRencana()
    {
        return $this->belongsTo(RencanaKerjasama::class, 'pengajuanrencana_id');
    }

    
}
