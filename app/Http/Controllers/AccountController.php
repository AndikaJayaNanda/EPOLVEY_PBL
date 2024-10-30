<?php

namespace App\Http\Controllers;

use App\Models\ProfilMahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class AccountController extends Controller
{

    public function create()
    {
        return view('admin.create_account');
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|min:10',
        'password' => 'required|string|min:6',
        'role' => 'required|in:Admin,Dosen,Mahasiswa',
    ]);

    // Memeriksa apakah username sudah terdaftar
    if (User::where('name', $request->name)->exists()) {
        return redirect()->back()->withErrors(['name' => 'Username sudah terdaftar.'])->withInput();
    }

    // Buat user baru
    $user = User::create([
        'name' => $request->name,
        'email_verified_at' => now(),
        'password' => bcrypt($request->password),
        'remember_token' => Str::random(10),
        'created_at' => now(),
        'updated_at' => now(),
        'role' => $request->role,
    ]);


    return redirect()->route('admin.manage_accounts')->with('success', 'Akun berhasil ditambahkan.');
}



public function update(Request $request, $id)
{
    
    $request->validate([
        'name' => 'required|string|max:255',
        'password' => 'nullable|string|min:6',
        'role' => 'required|in:Admin,Dosen,Mahasiswa',
    ]);

    $profil = User::findOrFail($id);
    $profil->name = $request->name;

    if ($request->filled('password')) {
        $profil->password = bcrypt($request->password);
    }

    $profil->role = $request->role; // Tambahkan role
    $profil->save();

    return redirect()->route('admin.manage_accounts')->with('success', 'Akun berhasil diperbarui.');
}


    // Menampilkan form untuk mengedit akun mahasiswa
    public function edit($id)
    {
        $profil = User::findOrFail($id);
        return view('admin.edit_account', compact('profil'));
    }

    // Memperbarui akun mahasiswa
    

    // Menghapus akun mahasiswa
    public function destroy($id)
    {
        $profil = User::findOrFail($id);
        $profil->delete();

        return redirect()->route('admin.manage_accounts')->with('success', 'Akun berhasil dihapus.');
    }
}
