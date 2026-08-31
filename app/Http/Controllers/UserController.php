<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('user.index');
    }

    /**
     * Get datatables data for user.
     */
    public function datatables(Request $request)
    {
        $query = User::query()
            ->select('users.id', 'users.nama_user', 'users.username', 'users.role', 'users.foto')
            ->with(['roleModel:id,nama']);

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('foto', function ($data) {
                $fotoUrl = safe_image_url($data->foto, 'foto_user', 'images/avatar.png');
                return '<img src="' . $fotoUrl . '" 
                            alt="Foto ' . htmlspecialchars($data->nama_user) . '" 
                            class="rounded-circle" 
                            width="32" 
                            height="32" 
                            style="object-fit: cover;">';
            })
            ->addColumn('nama_user', function ($data) {
                return $data->nama_user;
            })
            ->addColumn('username', function ($data) {
                return $data->username;
            })
            ->addColumn('role_nama', function ($data) {
                return $data->roleModel ? $data->roleModel->nama : '-';
            })
            ->addColumn('aksi', function ($data) {
                $html = '<div class="d-flex gap-1 flex-nowrap justify-content-center">';
                
                // Tombol Detail
                if (Auth::user()->hasPermission('user.view')) {
                    $html .= '<a href="' . route('user.show', $data->id) . '" 
                                 class="btn btn-sm btn-primary" 
                                 data-bs-toggle="tooltip" 
                                 title="Lihat">
                                <i class="ti ti-eye"></i>
                              </a>';
                }
                
                // Tombol Edit
                if (Auth::user()->hasPermission('user.edit')) {
                    $html .= '<a href="' . route('user.edit', $data->id) . '" 
                                 class="btn btn-sm btn-warning" 
                                 data-bs-toggle="tooltip" 
                                 title="Ubah">
                                <i class="ti ti-edit"></i>
                              </a>';
                }
                
                // Tombol Hapus
                if (Auth::user()->hasPermission('user.delete')) {
                    $isSelf = ($data->id === Auth::id()) ? 'true' : 'false';
                    $html .= '<button type="button" 
                                 class="btn btn-sm btn-danger btn-delete" 
                                 data-id="' . $data->id . '"
                                 data-nama="' . htmlspecialchars($data->username) . '"
                                 data-self="' . $isSelf . '"
                                 data-bs-toggle="tooltip" 
                                 title="Hapus">
                                <i class="ti ti-trash"></i>
                              </button>';
                }
                
                $html .= '</div>';
                return $html;
            })
            ->filterColumn('nama_user', function ($query, $keyword) {
                $query->where('nama_user', 'like', "%{$keyword}%");
            })
            ->filterColumn('username', function ($query, $keyword) {
                $query->where('username', 'like', "%{$keyword}%");
            })
            ->filterColumn('role_nama', function ($query, $keyword) {
                $query->whereHas('roleModel', function ($q) use ($keyword) {
                    $q->where('nama', 'like', "%{$keyword}%");
                });
            })
            ->rawColumns(['foto', 'aksi'])
            ->make(true);
    }

    /**
     * Display the specified resource.
     */
    public function show($id): View
    {
        // ambil data user berdasarkan id dengan relasi
        $user = User::with(['roleModel'])->findOrFail($id);

        // tampilkan halaman detail user
        return view('user.show', compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        $role = Role::all();
        // tampilkan form tambah data
        return view('user.create', compact('role'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Catat data yang diterima
        Log::info('Data yang diterima:', $request->all());

        // Validasi form
        $request->validate([
            'nama_user' => 'required',
            'username'  => 'required|unique:users',
            'password' => [
                'required',
                'string',
                'min:8',
                'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?~`]).{8,}$/',
            ],
            'role'      => 'required|exists:role,id',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'nama_user.required' => 'Nama user tidak boleh kosong.',
            'username.required'  => 'Username tidak boleh kosong.',
            'username.unique'    => 'Username sudah ada.',
            'password.required'  => 'Password tidak boleh kosong.',
            'password.min' => 'Password minimal 8 karakter.',
            'password.regex' => 'Password harus mengandung kombinasi huruf besar, huruf kecil, angka, dan simbol (!@#$%^&* dll).',
            'role.required'      => 'Role tidak boleh kosong.',
            'role.exists'        => 'Role yang dipilih tidak valid.'
        ]);

        // Upload foto jika ada
        $fotoPath = null;
        if ($request->hasFile('foto')) {
            $storedPath = $request->file('foto')->store('foto_user', 'public');
            $fotoPath = basename($storedPath); // Hanya nama file tanpa folder prefix
        }

        // Simpan data user
        $user = User::create([
            'nama_user' => $request->nama_user,
            'username'  => $request->username,
            'password'  => bcrypt($request->password),
            'role'      => $request->role,
            'foto' => $fotoPath,
        ]);

        // Log informasi data yang berhasil disimpan
        Log::info('Data user berhasil dibuat:', ['id' => $user->id]);

        // Redirect ke halaman index setelah berhasil simpan
        return redirect()->route('user.index')->with('success', 'Data user berhasil disimpan.');
    }



    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        // dapatkan data berdasarakan "id"
        $user = User::findOrFail($id);

        $role = Role::all();
        // tampilkan form ubah data
        return view('user.edit', compact('user', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // validasi form
        $request->validate([
            'nama_user' => 'required',
            'username'  => 'required|unique:users,username,' . $id,
            'role'      => 'required|exists:role,id',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // max 2MB
        ], [
            'nama_user.required' => 'Nama user tidak boleh kosong.',
            'username.required'  => 'Username tidak boleh kosong.',
            'username.unique'    => 'Username sudah ada.',
            'role.required'      => 'Role tidak boleh kosong.',
            'role.in'            => 'Role yang dipilih tidak valid.',
        ]);

        // ambil data user
        $user = User::findOrFail($id);

        // simpan data input ke array update
        $dataUpdate = [
            'nama_user' => $request->nama_user,
            'username'  => $request->username,
            'role'      => $request->role,
        ];

        // jika password diisi
        if ($request->filled('password')) {
            $request->validate([
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_+\-=\[\]{};\':"\\|,.<>\/?~`]).{8,}$/',
                ],
            ], [
                'password.required' => 'Password tidak boleh kosong.',
                'password.min' => 'Password minimal 8 karakter.',
                'password.regex' => 'Password harus mengandung kombinasi huruf besar, huruf kecil, angka, dan simbol (!@#$%^&* dll).',
            ]);

            $dataUpdate['password'] = bcrypt($request->password);
        }

        // jika ada file foto baru
        if ($request->hasFile('foto')) {
            // hapus foto lama jika ada
            if ($user->foto && \Illuminate\Support\Facades\Storage::exists('public/foto_user/' . $user->foto)) {
                \Illuminate\Support\Facades\Storage::delete('public/foto_user/' . $user->foto);
            }

            // simpan foto baru ke folder 'foto_user'
            $fotoPath = $request->file('foto')->store('foto_user', 'public');
            // Extract hanya nama file tanpa folder prefix
            $dataUpdate['foto'] = basename($fotoPath);
        }
        // Jika admin ingin hapus foto user (tanpa upload foto baru)
        elseif ($request->has('hapus_foto') && $request->hapus_foto == '1') {
            // hapus foto lama jika ada
            if ($user->foto && \Illuminate\Support\Facades\Storage::exists('public/foto_user/' . $user->foto)) {
                \Illuminate\Support\Facades\Storage::delete('public/foto_user/' . $user->foto);
            }
            // Set foto menjadi null
            $dataUpdate['foto'] = null;
        }

        // update data ke database
        $user->update($dataUpdate);

        // Jika user sedang update profil mereka sendiri dan ada foto baru
        if (Auth::id() == $user->id && $request->hasFile('foto')) {
            // Set flag untuk refresh avatar
            $request->session()->put('auth.photo_updated', true);
        }

        // redirect ke halaman index
        return redirect()->route('user.index')->with('success', 'Data user berhasil diubah.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cek apakah user yang akan dihapus adalah user yang sedang login
        if ($id == Auth::id()) {
            return redirect()->route('user.index')->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        // dapatkan data berdasarakan "id"
        $user = User::findOrFail($id);

        // hapus data
        $user->delete();

        // redirect ke halaman index dan tampilkan pesan berhasil hapus data
        return redirect()->route('user.index')->with('success', 'Data user berhasil dihapus.');
    }
}
