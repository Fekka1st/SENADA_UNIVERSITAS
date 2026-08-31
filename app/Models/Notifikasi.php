<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Notifikasi extends Model
{
    use HasFactory;

    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'jenis',
        'judul',
        'pesan',
        'data',
        'dibaca_pada'
    ];

    protected $casts = [
        'data' => 'array',
        'dibaca_pada' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    /**
     * Relasi dengan User
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope untuk notifikasi yang belum dibaca
     */
    public function scopeBelumDibaca($query)
    {
        return $query->whereNull('dibaca_pada');
    }

    /**
     * Scope untuk notifikasi yang sudah dibaca
     */
    public function scopeSudahDibaca($query)
    {
        return $query->whereNotNull('dibaca_pada');
    }

    /**
     * Mark notifikasi sebagai sudah dibaca
     */
    public function tandaiSudahDibaca()
    {
        if (is_null($this->dibaca_pada)) {
            $this->update(['dibaca_pada' => now()]);
        }
    }

    /**
     * Cek apakah notifikasi sudah dibaca
     */
    public function sudahDibaca(): bool
    {
        return !is_null($this->dibaca_pada);
    }

    /**
     * Get URL untuk redirect ketika notifikasi diklik
     */
    public function getUrlAttribute(): ?string
    {
        $data = $this->data ?? [];

        // Cek jika ada URL custom di data
        if (isset($data['url'])) {
            return $data['url'];
        }

        // Default fallback ke dashboard
        return route('dashboard.index');
    }

    /**
     * Get icon untuk jenis notifikasi
     */
    public function getIconAttribute(): string
    {
        // Cek jika ada icon custom di data
        if (isset($this->data['icon'])) {
            return $this->data['icon'];
        }

        // Default icons berdasarkan jenis umum
        return match ($this->jenis) {
            'success', 'approved', 'completed' => 'ti ti-check',
            'error', 'rejected', 'cancelled' => 'ti ti-x',
            'warning', 'alert' => 'ti ti-alert-triangle',
            'info', 'notification' => 'ti ti-info-circle',
            'new', 'created' => 'ti ti-bell-ringing',
            'updated', 'changed' => 'ti ti-arrows-exchange',
            'report', 'summary' => 'ti ti-chart-bar',
            default => 'ti ti-bell',
        };
    }

    /**
     * Format waktu relatif
     */
    public function getWaktuRelatifAttribute(): string
    {
        return $this->created_at->diffForHumans();
    }

    /**
     * Get warna berdasarkan jenis notifikasi
     */
    public function getWarnaAttribute(): string
    {
        // Cek jika ada warna custom di data
        if (isset($this->data['color'])) {
            return $this->data['color'];
        }

        // Default warna berdasarkan jenis umum
        return match ($this->jenis) {
            'error', 'rejected', 'cancelled', 'danger' => 'danger',
            'success', 'approved', 'completed' => 'success',
            'info', 'notification' => 'info',
            'warning', 'alert', 'new', 'created' => 'warning',
            'updated', 'changed' => 'purple',
            default => 'primary',
        };
    }

    /**
     * Get kelas CSS untuk icon berdasarkan jenis notifikasi  
     */
    public function getIconClassAttribute(): string
    {
        $warna = $this->warna;
        return "avatar avatar-xs bg-{$warna} text-white rounded-2 d-inline-flex align-items-center justify-content-center";
    }

    /**
     * Get kelas CSS untuk badge berdasarkan jenis notifikasi
     */
    public function getBadgeClassAttribute(): string
    {
        $warna = $this->warna;
        return "badge bg-{$warna}";
    }
}
