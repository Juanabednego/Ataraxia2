<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SuperAdminController extends Controller
{
    // Tampilkan akun (aktif / nonaktif / semua)
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'active'); // default: aktif

        if ($filter === 'nonaktif') {
            $users = User::onlyTrashed()->get(); // hanya yang soft deleted
        } elseif ($filter === 'all') {
            $users = User::withTrashed()->get(); // semua
        } else {
            $users = User::all(); // hanya aktif
        }

        return view('admin.Kelola-akun', compact('users', 'filter'));
    }

    // Simpan akun baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'role' => 'required|in:user,admin',
            'password' => 'required|min:6',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('superadmin.kelola-akun')->with('success', 'Akun berhasil ditambahkan.');
    }

    // Nonaktifkan akun (soft delete)
    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->role === 'superadmin') {
            return back()->with('error', 'Tidak dapat menghapus superadmin.');
        }

        $user->delete(); // soft delete
        return redirect()->route('superadmin.kelola-akun')->with('success', 'Akun berhasil dinonaktifkan.');
    }

    // Pulihkan akun yang di-soft delete
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('superadmin.kelola-akun', ['filter' => 'nonaktif'])->with('success', 'Akun berhasil dipulihkan.');
    }
}
