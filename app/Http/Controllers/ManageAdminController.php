<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ManageAdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // //
        // $admins = User::role('admin')->get(); // hanya user dengan role admin
        // return view('manage-admins.index', compact('admins'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        //  $dispositions = [
        //     'Sekretariat',
        //     'Pendaftaran Penduduk',
        //     'Pencatatan Sipil',
        //     'Pengelolaan Informasi Administrasi Kependudukan',
        //     'Pemanfaatan Data dan Inovasi Pelayanan'
        //  ]; // tetap seperti yang kamu punya
        // $roles = Role::all(); // Ambil semua role dari DB
        // return view('users.create', compact('dispositions', 'roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    //      $request->validate([
    //     'nama_akun' => 'required|string|max:255|unique:users,name',
    //     'password' => 'required|string|min:6|confirmed',
    //     'bidang' => 'required',
    // ]);

    // $user = User::create([
    //     'name' => $request->nama_akun,
    //     'password' => Hash::make($request->password),
    //     'bidang' => $request->bidang,
    // ]);

    // $user->assignRole('admin'); // default assign role admin

    // return redirect()->route('manage-admin.index')->with('success', 'Admin berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
        // $user = User::findOrFail($id);

        // if (!$user->hasRole('admin')) {
        //     abort(403, 'User bukan admin');
        // }

        // $dispositions = [
        //     'Sekretariat',
        //     'Pendaftaran Penduduk',
        //     'Pencatatan Sipil',
        //     'Pengelolaan Informasi Administrasi Kependudukan',
        //     'Pemanfaatan Data dan Inovasi Pelayanan'
        // ];

        // return view('manage-admins.edit', compact('user', 'dispositions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        // $user = User::findOrFail($id);

        // if (!$user->hasRole('admin')) {
        //     abort(403, 'User bukan admin');
        // }

        // $request->validate([
        //     'nama_akun' => 'required|string|max:255|unique:users,name,' . $user->id,
        //     'password' => 'nullable|string|min:6|confirmed',
        //     'bidang' => 'required',
        // ]);

        // $user->name = $request->nama_akun;
        // $user->bidang = $request->bidang;

        // if ($request->password) {
        //     $user->password = Hash::make($request->password);
        // }

        // $user->save();

        // return redirect()->route('manage-admin.index')->with('success', 'Data admin berhasil diperbarui!');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        //  $user = User::findOrFail($id);

        // if (!$user->hasRole('admin')) {
        //     abort(403, 'User bukan admin');
        // }

        // $user->delete();

        // return redirect()->route('manage-admin.index')->with('success', 'Admin berhasil dihapus!');

    }
}
