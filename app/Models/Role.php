<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';
    protected $primaryKey = 'id';
    
    protected $fillable = [
        'nama'
    ];

    /**
     * Relasi dengan User (one-to-many)
     */
    public function user(): HasMany
    {
        return $this->hasMany(User::class, 'role', 'id');
    }

    /**
     * Relasi dengan Permission (many-to-many)
     */
    public function permissions(): BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'role_permissions');
    }

    /**
     * Cek apakah role memiliki permission tertentu
     */
    public function hasPermission(string $permission): bool
    {
        return $this->permissions()->where('name', $permission)->exists();
    }

    /**
     * Berikan permission ke role
     */
    public function givePermission(string $permission): void
    {
        $permissionModel = Permission::where('name', $permission)->first();
        if ($permissionModel && !$this->hasPermission($permission)) {
            $this->permissions()->attach($permissionModel->id);
        }
    }

    /**
     * Cabut permission dari role
     */
    public function revokePermission(string $permission): void
    {
        $permissionModel = Permission::where('name', $permission)->first();
        if ($permissionModel) {
            $this->permissions()->detach($permissionModel->id);
        }
    }
}
