<?php

namespace App\Services;

use App\Models\Notifikasi;
use App\Models\User;
use App\Events\NotifikasiBaru;
use Illuminate\Support\Facades\Log;
use Throwable;

class NotifikasiService
{
    /**
     * Safely broadcast an event via Laravel Reverb WebSocket
     * 
     * Fungsi ini akan mencoba broadcast event ke Reverb server.
     * Jika Reverb server tidak aktif atau koneksi gagal, error akan di-catch
     * dan sistem akan tetap berjalan normal (graceful degradation).
     * 
     * Client-side akan otomatis fallback ke HTTP polling jika WebSocket tidak tersedia.
     * 
     * @param mixed $event Event yang akan di-broadcast (NotifikasiBaru)
     * @return void
     */
    protected static function safeBroadcast($event): void
    {
        try {
            broadcast($event);
        } catch (Throwable $e) {
            Log::warning('Broadcast failed (fallback to polling): ' . $e->getMessage());
        }
    }

    /**
     * Kirim notifikasi ke user tertentu
     * 
     * @param int|array $userIds User ID atau array User IDs
     * @param string $jenis Jenis notifikasi (success, error, warning, info, new, updated, dll)
     * @param string $judul Judul notifikasi
     * @param string $pesan Pesan notifikasi
     * @param array $data Data tambahan untuk notifikasi (bisa include: url, icon, color)
     * @return void
     * 
     * @example
     * NotifikasiService::kirim(1, 'success', 'Data Berhasil Disimpan', 'Data Anda telah tersimpan.', [
     *     'url' => route('data.show', 1),
     *     'icon' => 'ti ti-check',
     *     'color' => 'success'
     * ]);
     */
    public static function kirim($userIds, string $jenis, string $judul, string $pesan, array $data = [])
    {
        // Pastikan $userIds adalah array
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }

        foreach ($userIds as $userId) {
            $notifikasi = Notifikasi::create([
                'user_id' => $userId,
                'jenis' => $jenis,
                'judul' => $judul,
                'pesan' => $pesan,
                'data' => $data
            ]);

            self::safeBroadcast(new NotifikasiBaru($notifikasi));
        }
    }

    /**
     * Kirim notifikasi ke user dengan permission tertentu
     * 
     * @param string|array $permissions Permission atau array permissions
     * @param string $jenis Jenis notifikasi
     * @param string $judul Judul notifikasi
     * @param string $pesan Pesan notifikasi
     * @param array $data Data tambahan
     * @return void
     * 
     * @example
     * NotifikasiService::kirimKePermission('user.create', 'info', 'User Baru', 'User baru telah ditambahkan.');
     * NotifikasiService::kirimKePermission(['user.edit', 'user.delete'], 'warning', 'Perhatian', 'Ada perubahan penting.');
     */
    public static function kirimKePermission($permissions, string $jenis, string $judul, string $pesan, array $data = [])
    {
        if (!is_array($permissions)) {
            $permissions = [$permissions];
        }

        $users = User::whereHas('roleModel.permissions', function ($query) use ($permissions) {
            $query->whereIn('name', $permissions);
        })->get();

        foreach ($users as $user) {
            self::kirim($user->id, $jenis, $judul, $pesan, $data);
        }
    }

    /**
     * Kirim notifikasi ke user dengan role tertentu
     * 
     * @param string|array $roleNames Nama role atau array nama roles
     * @param string $jenis Jenis notifikasi
     * @param string $judul Judul notifikasi
     * @param string $pesan Pesan notifikasi
     * @param array $data Data tambahan
     * @return void
     * 
     * @example
     * NotifikasiService::kirimKeRole('Super Admin', 'alert', 'Peringatan Sistem', 'Ada aktivitas mencurigakan.');
     * NotifikasiService::kirimKeRole(['Super Admin', 'Admin'], 'info', 'Update', 'Sistem telah diperbarui.');
     */
    public static function kirimKeRole($roleNames, string $jenis, string $judul, string $pesan, array $data = [])
    {
        if (!is_array($roleNames)) {
            $roleNames = [$roleNames];
        }

        $users = User::whereHas('roleModel', function ($query) use ($roleNames) {
            $query->whereIn('nama', $roleNames);
        })->get();

        foreach ($users as $user) {
            self::kirim($user->id, $jenis, $judul, $pesan, $data);
        }
    }

    /**
     * Kirim notifikasi ke semua user (broadcast)
     * 
     * @param string $jenis Jenis notifikasi
     * @param string $judul Judul notifikasi
     * @param string $pesan Pesan notifikasi
     * @param array $data Data tambahan
     * @return void
     * 
     * @example
     * NotifikasiService::kirimKeSemuaUser('info', 'Maintenance', 'Sistem akan maintenance besok.');
     */
    public static function kirimKeSemuaUser(string $jenis, string $judul, string $pesan, array $data = [])
    {
        $users = User::all();

        foreach ($users as $user) {
            self::kirim($user->id, $jenis, $judul, $pesan, $data);
        }
    }

    /**
     * Mark semua notifikasi user sebagai sudah dibaca
     * 
     * @param int $userId User ID
     * @return void
     */
    public static function tandaiSemuaSudahDibaca(int $userId)
    {
        Notifikasi::where('user_id', $userId)
            ->whereNull('dibaca_pada')
            ->update(['dibaca_pada' => now()]);
    }

    /**
     * Mark notifikasi tertentu sebagai sudah dibaca
     * 
     * @param int $notifikasiId Notifikasi ID
     * @return bool
     */
    public static function tandaiSudahDibaca(int $notifikasiId): bool
    {
        $notifikasi = Notifikasi::find($notifikasiId);
        
        if ($notifikasi && is_null($notifikasi->dibaca_pada)) {
            return $notifikasi->update(['dibaca_pada' => now()]);
        }
        
        return false;
    }

    /**
     * Hapus notifikasi lama (cleanup)
     * Dipanggil otomatis via scheduled command: notifikasi:bersihkan-lama
     * 
     * @return void
     */
    public static function bersihkanNotifikasiLama()
    {
        // Hapus notifikasi yang sudah dibaca lebih dari 30 hari
        $deletedRead = Notifikasi::whereNotNull('dibaca_pada')
            ->where('dibaca_pada', '<', now()->subDays(30))
            ->delete();

        // Hapus notifikasi yang belum dibaca lebih dari 90 hari
        $deletedUnread = Notifikasi::whereNull('dibaca_pada')
            ->where('created_at', '<', now()->subDays(90))
            ->delete();

        // Batasi maksimal 50 notifikasi per user (hapus yang paling lama)
        $users = User::has('notifikasi', '>', 50)->get();

        $deletedExcess = 0;
        foreach ($users as $user) {
            $notifikasiLama = Notifikasi::where('user_id', $user->id)
                ->orderBy('created_at', 'desc')
                ->skip(50)
                ->pluck('id');

            if ($notifikasiLama->isNotEmpty()) {
                $deletedExcess += Notifikasi::whereIn('id', $notifikasiLama)->delete();
            }
        }

        Log::info('Notifikasi lama dibersihkan', [
            'deleted_read' => $deletedRead,
            'deleted_unread' => $deletedUnread,
            'deleted_excess' => $deletedExcess,
            'total_deleted' => $deletedRead + $deletedUnread + $deletedExcess
        ]);
    }

    /**
     * Hapus semua notifikasi user tertentu
     * 
     * @param int $userId User ID
     * @return int Jumlah notifikasi yang dihapus
     */
    public static function hapusSemuaNotifikasi(int $userId): int
    {
        return Notifikasi::where('user_id', $userId)->delete();
    }

    /**
     * Get jumlah notifikasi belum dibaca untuk user
     * 
     * @param int $userId User ID
     * @return int
     */
    public static function hitungBelumDibaca(int $userId): int
    {
        return Notifikasi::where('user_id', $userId)
            ->whereNull('dibaca_pada')
            ->count();
    }

    /**
     * Get notifikasi terbaru untuk user
     * 
     * @param int $userId User ID
     * @param int $limit Limit jumlah notifikasi
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNotifikasiTerbaru(int $userId, int $limit = 10)
    {
        return Notifikasi::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Get semua notifikasi belum dibaca untuk user
     * 
     * @param int $userId User ID
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getNotifikasiBelumDibaca(int $userId)
    {
        return Notifikasi::where('user_id', $userId)
            ->whereNull('dibaca_pada')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    /**
     * Cek apakah user memiliki notifikasi belum dibaca
     * 
     * @param int $userId User ID
     * @return bool
     */
    public static function adaBelumDibaca(int $userId): bool
    {
        return Notifikasi::where('user_id', $userId)
            ->whereNull('dibaca_pada')
            ->exists();
    }
}
