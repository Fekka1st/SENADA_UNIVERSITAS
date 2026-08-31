<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('role.index');
    }

    /**
     * Get datatables data for role.
     */
    public function datatables(Request $request)
    {
        $query = Role::query()
            ->select('id', 'nama')
            ->withCount('user');

        return DataTables::eloquent($query)
            ->addIndexColumn()
            ->addColumn('nama', function ($data) {
                return $data->nama;
            })
            ->addColumn('aksi', function ($data) {
                $html = '<div class="d-flex gap-1 flex-nowrap">';

                // Tombol Detail
                if (Auth::user()->hasPermission('role.view')) {
                    $html .= '<a href="' . route('role.show', $data->id) . '"
                                 class="btn btn-sm btn-primary"
                                 data-bs-toggle="tooltip"
                                 title="Lihat">
                                <i class="ti ti-eye"></i>
                              </a>';
                }

                // Tombol Edit
                if (Auth::user()->hasPermission('role.edit')) {
                    $html .= '<a href="' . route('role.edit', $data->id) . '"
                                 class="btn btn-sm btn-warning"
                                 data-bs-toggle="tooltip"
                                 title="Ubah">
                                <i class="ti ti-edit"></i>
                              </a>';
                }

                // Tombol Hapus
                if (Auth::user()->hasPermission('role.delete')) {
                    $html .= '<button type="button"
                                 class="btn btn-sm btn-danger btn-delete"
                                 data-id="' . $data->id . '"
                                 data-nama="' . htmlspecialchars($data->nama) . '"
                                 data-count="' . $data->user_count . '"
                                 data-bs-toggle="tooltip"
                                 title="Hapus">
                                <i class="ti ti-trash"></i>
                              </button>';
                }

                $html .= '</div>';
                return $html;
            })
            ->filterColumn('nama', function ($query, $keyword) {
                $query->where('nama', 'like', "%{$keyword}%");
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    public function show($id): View
    {
        // ambil data role berdasarkan id dengan relasi
        $role = Role::with(['permissions', 'user'])->findOrFail($id);

        // ambil semua permissions yang dikelompokkan berdasarkan module
        $allPermissions = Permission::all()->groupBy('module');

        // ambil id permissions yang dimiliki role ini
        $rolePermissionIds = $role->permissions->pluck('id')->toArray();

        // tampilkan halaman detail role
        return view('role.show', compact('role', 'allPermissions', 'rolePermissionIds'));
    }

    public function create(): View
    {
        // Ambil semua permissions yang dikelompokkan berdasarkan module
        $allPermissions = Permission::all()->groupBy('module');

        // Definisikan urutan module core saja
        $moduleOrder = [
            'dashboard',
            'role',
            'user',
            'pengaturan',
            'profile',
            'backup_database'
        ];

        // Urutkan permissions berdasarkan urutan module yang diinginkan
        $permissions = collect();
        foreach ($moduleOrder as $module) {
            if (isset($allPermissions[$module])) {
                $permissions[$module] = $allPermissions[$module];
            }
        }

        // tampilkan form tambah data
        return view('role.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // validasi form
        $request->validate([
            'nama' => 'required|unique:role',
            'permissions' => 'array'
        ], [
            'nama.required' => 'Role tidak boleh kosong.',
            'nama.unique'   => 'Role dokumen sudah ada.'
        ]);

        // simpan data
        $role = Role::create([
            'nama' => $request->nama
        ]);

        // Assign permissions jika ada
        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        }

        // redirect ke halaman index dan tampilkan pesan berhasil simpan data
        return redirect()->route('role.index')->with('success', 'Role berhasil disimpan.');
    }

     public function edit($id)
    {
        // Ambil data role
        $role = Role::with('permissions')->findOrFail($id);


        $allPermissions = Permission::all()->groupBy('module');

        $priorityOrder = [
            'dashboard',
            'role',
            'user',
            'pengaturan',
            'profile',
            'backup_database',

        ];

        $permissions = collect();

        foreach ($priorityOrder as $module) {
            if ($allPermissions->has($module)) {
                $permissions->put($module, $allPermissions->get($module));
                // PENTING: Hapus dari $allPermissions agar tidak duplikat
                $allPermissions->forget($module);
            }
        }


        $permissions = $permissions->merge($allPermissions->sortKeys());

        $rolePermissions = $role->permissions->pluck('id')->toArray();

        return view('role.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        // validasi form
        $request->validate([
            'nama' => 'required|unique:role,nama,' . $id,
            'permissions' => 'array'
        ], [
            'nama.required' => 'Role tidak boleh kosong.',
            'nama.unique'   => 'Role dokumen sudah ada.'
        ]);

        // cari data role berdasarkan id dan update
        $role = Role::findOrFail($id);
        $role->update([
            'nama' => $request->nama
        ]);

        // Update permissions
        if ($request->permissions) {
            $role->permissions()->sync($request->permissions);
        } else {
            $role->permissions()->detach();
        }

        // redirect ke halaman index dengan pesan sukses
        return redirect()->route('role.index')->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy($id): RedirectResponse
    {
        // cari data berdasarkan id
        $role = Role::findOrFail($id);

        // hapus data
        $role->delete();

        // redirect ke halaman role dengan pesan sukses
        return redirect()->route('role.index')->with('success', 'Role berhasil dihapus.');
    }
}
