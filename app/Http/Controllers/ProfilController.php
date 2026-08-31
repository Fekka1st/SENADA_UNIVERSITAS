<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class ProfilController extends Controller
{
    /**
     * Show the form for editing the user's profile.
     */
    public function edit(): View
    {
        $user = User::find(Auth::id());
        
        return view('profil.edit', [
            'user' => $user
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $userId = Auth::id();
        $user = User::find($userId);

        // Validasi form
        $request->validate([
            'nama_user' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:users,username,' . $userId,
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ], [
            'nama_user.required' => 'Nama tidak boleh kosong.',
            'username.required' => 'Username tidak boleh kosong.',
            'username.unique' => 'Username sudah digunakan.',
            'foto.image' => 'File harus berupa gambar.',
            'foto.mimes' => 'Format foto harus jpg, jpeg, atau png.',
            'foto.max' => 'Ukuran foto maksimal 2MB.',
        ]);

        // Data yang akan diupdate
        $dataUpdate = [
            'nama_user' => $request->nama_user,
            'username' => $request->username,
        ];

        // Jika ada file foto baru
        if ($request->hasFile('foto')) {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::exists('public/foto_user/' . $user->foto)) {
                Storage::delete('public/foto_user/' . $user->foto);
            }

            // Simpan foto baru - hanya nama file, bukan dengan folder prefix
            $fotoPath = $request->file('foto')->store('foto_user', 'public');
            // Extract hanya nama file tanpa folder prefix
            $dataUpdate['foto'] = basename($fotoPath);
        }
        // Jika user ingin hapus foto (tanpa upload foto baru)
        elseif ($request->has('hapus_foto') && $request->hapus_foto == '1') {
            // Hapus foto lama jika ada
            if ($user->foto && Storage::exists('public/foto_user/' . $user->foto)) {
                Storage::delete('public/foto_user/' . $user->foto);
            }
            // Set foto menjadi null
            $dataUpdate['foto'] = null;
        }

        // Update data user
        $user->update($dataUpdate);

        // Refresh auth session tanpa logout/login
        // Gunakan session()->invalidate() dan reload user baru
        if ($request->hasFile('foto')) {
            $request->session()->put('auth.photo_updated', true);
        }

        return back()->with('success', 'Profil berhasil diperbarui.');
    }
}
