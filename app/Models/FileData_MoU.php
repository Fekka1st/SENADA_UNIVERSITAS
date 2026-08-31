<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileData_MoU extends Model
{
    //

    use HasFactory;

    protected $table = 'file_registrasi_mou';

    protected $fillable = [
        'registrasimou_id',
        'nama_file',
        'file_path',
        'type_file',
        'size',
    ];


    public function mou()
    {
        return $this->belongsTo(Data_MoU::class, 'registrasimou_id');
    }


    public function getFormattedSizeAttribute()
    {
        return formatBytes($this->size);
    }


    public function getFileUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}
