<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:superadmin']); // Batasi hanya superadmin
    }

    /**
     * Tampilkan daftar semua user.
     */
    public function index()
    {
        $users = User::with('roles')->get();
        return view('users.index', compact('users'));
    }

    /**
     * Tampilkan form untuk membuat user baru.
     */
    public function create()
    {
        $dispositions = ['Sekretariat', 'DAFDUK', 'CAPIL', 'PIAK', 'PDIP'];
        $roles = Role::pluck('name', 'id');

        return view('users.create', compact('dispositions', 'roles'));
    }

    /**
     * Simpan user baru ke database.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_akun' => 'required|string|max:255|unique:users,name',
            'password' => 'required|string|min:6|confirmed',
            'bidang' => 'required|in:Sekretariat,Pendaftaran Penduduk,Pencatatan Sipil,Pengelolaan Informasi Administrasi Kependudukan,Pemanfaatan Data dan Inovasi Pelayanan',
            'role' => 'required|exists:roles,id',
        ]);

        $user = User::create([
            'name' => $request->nama_akun,
            'password' => Hash::make($request->password),
            'bidang' => $request->bidang,
        ]);

        $role = Role::find($request->role);
        $user->assignRole($role->name);

        return redirect()->route('users.index')->with('success', 'Akun berhasil dibuat!');
    }

    /**
     * Tampilkan form untuk mengedit user.
     */
    public function edit(User $user)
    {
        $dispositions = ['Sekretariat', 'DAFDUK', 'CAPIL', 'PIAK', 'PDIP'];
        $roles = Role::pluck('name', 'id');

        return view('users.edit', compact('user', 'dispositions', 'roles'));
    }

    /**
     * Update user di database.
     */
    public function update(Request $request, User $user)
    {
        $request->validate([
            'nama_akun' => 'required|string|max:255|unique:users,name,' . $user->id,
            'password' => 'nullable|string|min:6|confirmed',
            'bidang' => 'required|in:Sekretariat,Pendaftaran Penduduk,Pencatatan Sipil,Pengelolaan Informasi Administrasi Kependudukan,Pemanfaatan Data dan Inovasi Pelayanan',
            'role' => 'required|exists:roles,id',
        ]);

        $user->name = $request->nama_akun;
        $user->bidang = $request->bidang;

        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        $role = Role::find($request->role);
        $user->syncRoles([$role->name]);

        return redirect()->route('users.index')->with('success', 'Akun berhasil diperbarui!');
    }

    /**
     * Hapus user dari database.
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Akun berhasil dihapus!');
    }
}
