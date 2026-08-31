<?php

namespace App\Http\Controllers;

use App\Models\Pengaturan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class PengaturanController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function index(): View
    {
        // dapatkan data berdasarakan "id"
        $pengaturan = Pengaturan::findOrFail(1);

        // tampilkan data ke view
        return view('pengaturan.index', compact('pengaturan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(): View
    {
        // dapatkan data berdasarakan "id"
        $pengaturan = Pengaturan::findOrFail(1);

        // tampilkan form ubah data
        return view('pengaturan.edit', compact('pengaturan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request): RedirectResponse
    {
        // Debug: Log request data
        Log::info('PengaturanController update called', [
            'has_logo_instnasi' => $request->hasFile('logo_instnasi'),
            'request_data' => $request->except('_token', '_method'),
        ]);

        // validasi form
        $request->validate([
            'nama_aplikasi' => 'required',
            'kepanjangan_aplikasi' => 'required',
            'nama_copyright' => 'required',
            'tema_warna_utama' => ['required', 'regex:/^#([A-Fa-f0-9]{6}|[A-Fa-f0-9]{3})$/'],
            'logo_instnasi' => 'nullable|image|mimes:jpeg,jpg,png|max:1024',
            'favicon' => 'nullable|image|mimes:jpeg,jpg,png,ico|max:512',
            'background_login' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'sosmed_facebook' => 'nullable|url',
            'sosmed_twitter' => 'nullable|url',
            'sosmed_instagram' => 'nullable|url',
            'sosmed_youtube' => 'nullable|url',
            'sosmed_tiktok' => 'nullable|url',
        ], [
            'nama_aplikasi.required' => 'Nama Aplikasi tidak boleh kosong.',
            'kepanjangan_aplikasi.required' => 'Kepanjangan Nama Aplikasi tidak boleh kosong.',
            'nama_copyright.required' => 'Nama Copyright tidak boleh kosong.',
            'tema_warna_utama.required' => 'Warna tema utama tidak boleh kosong.',
            'tema_warna_utama.regex' => 'Format warna tema utama tidak valid. Gunakan format hex (#RRGGBB).',
            'logo_instnasi.image' => 'Logo harus berupa file gambar dengan jenis: jpeg, jpg, png.',
            'logo_instnasi.mimes' => 'Logo harus berupa file dengan jenis: jpeg, jpg, png.',
            'logo_instnasi.max' => 'Logo tidak boleh lebih besar dari 1 MB.',
            'favicon.image' => 'Favicon harus berupa file gambar dengan jenis: jpeg, jpg, png, ico.',
            'favicon.mimes' => 'Favicon harus berupa file dengan jenis: jpeg, jpg, png, ico.',
            'favicon.max' => 'Favicon tidak boleh lebih besar dari 512 KB.',
            'background_login.image' => 'Background Login harus berupa file gambar dengan jenis: jpeg, jpg, png.',
            'background_login.mimes' => 'Background Login harus berupa file dengan jenis: jpeg, jpg, png.',
            'background_login.max' => 'Background Login tidak boleh lebih besar dari 2 MB.',
            'sosmed_facebook.url' => 'Link Facebook harus berupa URL yang valid.',
            'sosmed_twitter.url' => 'Link Twitter harus berupa URL yang valid.',
            'sosmed_instagram.url' => 'Link Instagram harus berupa URL yang valid.',
            'sosmed_youtube.url' => 'Link YouTube harus berupa URL yang valid.',
            'sosmed_tiktok.url' => 'Link TikTok harus berupa URL yang valid.',
        ]);

        // dapatkan data berdasarkan ID
        $pengaturan = Pengaturan::findOrFail(1);

        $data = [
            'nama_aplikasi' => $request->nama_aplikasi,
            'kepanjangan_aplikasi' => $request->kepanjangan_aplikasi,
            'nama_copyright' => $request->nama_copyright,
            'tema_warna_utama' => $request->tema_warna_utama,
            'sosmed_facebook' => $request->sosmed_facebook,
            'sosmed_twitter' => $request->sosmed_twitter,
            'sosmed_instagram' => $request->sosmed_instagram,
            'sosmed_youtube' => $request->sosmed_youtube,
            'sosmed_tiktok' => $request->sosmed_tiktok,
        ];

        // Handle hapus favicon
        if ($request->has('hapus_favicon') && $request->hapus_favicon) {
            Log::info('Processing favicon deletion');

            // hapus file favicon lama jika ada
            if ($pengaturan->favicon && Storage::exists('public/favicon/'.$pengaturan->favicon)) {
                Storage::delete('public/favicon/'.$pengaturan->favicon);
                Log::info('Favicon deleted: '.$pengaturan->favicon);
            }

            // set favicon jadi null
            $data['favicon'] = null;
        }
        // jika ada file favicon baru
        elseif ($request->hasFile('favicon')) {
            Log::info('Processing favicon upload');
            $favicon = $request->file('favicon');

            // Buat nama file unik
            $filename = 'favicon_'.time().'.'.$favicon->getClientOriginalExtension();

            // Store file
            $favicon->storeAs('public/favicon', $filename);
            Log::info('Favicon stored as: '.$filename);

            // hapus favicon lama jika ada
            if ($pengaturan->favicon && Storage::exists('public/favicon/'.$pengaturan->favicon)) {
                Storage::delete('public/favicon/'.$pengaturan->favicon);
                Log::info('Old favicon deleted: '.$pengaturan->favicon);
            }

            // simpan nama file baru
            $data['favicon'] = $filename;
        }

        // Handle hapus background login
        if ($request->has('hapus_background_login') && $request->hapus_background_login) {
            Log::info('Processing background login deletion');

            // hapus file background login lama jika ada
            if ($pengaturan->background_login && Storage::exists('public/background_login/'.$pengaturan->background_login)) {
                Storage::delete('public/background_login/'.$pengaturan->background_login);
                Log::info('Background login deleted: '.$pengaturan->background_login);
            }

            // set background login jadi null
            $data['background_login'] = null;
        }
        // jika ada file background_login baru
        elseif ($request->hasFile('background_login')) {
            Log::info('Processing background_login upload');
            $backgroundLogin = $request->file('background_login');

            // Buat nama file unik
            $filename = 'bg_login_'.time().'.'.$backgroundLogin->getClientOriginalExtension();

            // Store file
            $backgroundLogin->storeAs('public/background_login', $filename);
            Log::info('Background login stored as: '.$filename);

            // hapus background login lama jika ada
            if ($pengaturan->background_login && Storage::exists('public/background_login/'.$pengaturan->background_login)) {
                Storage::delete('public/background_login/'.$pengaturan->background_login);
                Log::info('Old background login deleted: '.$pengaturan->background_login);
            }

            // simpan nama file baru
            $data['background_login'] = $filename;
        }

        // Handle hapus logo pengaturan
        if ($request->has('hapus_logo_instnasi') && $request->hapus_logo_instnasi) {
            Log::info('Processing logo pengaturan deletion');

            // hapus file logo lama jika ada
            if ($pengaturan->logo_instnasi && Storage::exists('public/logo/'.$pengaturan->logo_instnasi)) {
                Storage::delete('public/logo/'.$pengaturan->logo_instnasi);
                Log::info('Logo pengaturan deleted: '.$pengaturan->logo_instnasi);
            }

            // set logo pengaturan jadi null
            $data['logo_instnasi'] = null;
        }
        // jika ada file logo_instnasi baru
        elseif ($request->hasFile('logo_instnasi')) {
            Log::info('Processing logo_instnasi upload');
            $logoPengaturan = $request->file('logo_instnasi');

            // Buat nama file unik
            $filename = 'pengaturan_'.time().'.'.$logoPengaturan->getClientOriginalExtension();

            // Store file
            $logoPengaturan->storeAs('public/logo', $filename);
            Log::info('Logo pengaturan stored as: '.$filename);

            // hapus logo lama jika ada
            if ($pengaturan->logo_instnasi && Storage::exists('public/logo/'.$pengaturan->logo_instnasi)) {
                Storage::delete('public/logo/'.$pengaturan->logo_instnasi);
                Log::info('Old logo pengaturan deleted: '.$pengaturan->logo_instnasi);
            }

            // simpan nama file baru
            $data['logo_instnasi'] = $filename;
        }

        // update data
        $pengaturan->update($data);

        // redirect ke halaman index dan tampilkan pesan berhasil
        return redirect()->route('pengaturan.index')->with('success', 'Data pengaturan berhasil diubah.');
    }
}
