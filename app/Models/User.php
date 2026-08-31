<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // Tambahkan ini
use App\Models\Role; // Tambahkan ini jika belum ada

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nama_user',
        'username',
        'password',
        'role',
        'foto',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
        ];
    }

    /**
     * Relasi dengan Role
     */
    public function roleModel()
    {
        return $this->belongsTo(Role::class, 'role');
    }

    /**
     * Cek apakah user memiliki permission tertentu
     */
    public function hasPermission(string $permission): bool
    {
        $role = $this->roleModel;
        return $role && $role->hasPermission($permission);
    }

    /**
     * Cek apakah user memiliki salah satu dari beberapa permissions
     */
    public function hasAnyPermission(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission)) {
                return true;
            }
        }
        return false;
    }

    /**
     * Cek apakah user memiliki semua permissions yang diberikan
     */
    public function hasAllPermissions(array $permissions): bool
    {
        foreach ($permissions as $permission) {
            if (!$this->hasPermission($permission)) {
                return false;
            }
        }
        return true;
    }

    /**
     * Relasi dengan Notifikasi
     */
    public function notifikasi()
    {
        return $this->hasMany(\App\Models\Notifikasi::class)->orderBy('created_at', 'desc');
    }

    /**
     * Get notifikasi yang belum dibaca
     */
    public function notifikasiBelumDibaca()
    {
        return $this->hasMany(\App\Models\Notifikasi::class)->whereNull('dibaca_pada');
    }

    /**
     * Get jumlah notifikasi belum dibaca
     */
    public function getJumlahNotifikasiBelumDibacaAttribute(): int
    {
        return $this->notifikasiBelumDibaca()->count();
    }

    public function fakultas(): BelongsTo
    {
        return $this->belongsTo(Fakultas::class, 'fakultas_id');
    }

    public function prodi(): BelongsTo
    {
        return $this->belongsTo(prodi::class, 'prodi_id');
    }

}
