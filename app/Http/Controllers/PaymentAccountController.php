<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentAccount;

class PaymentAccountController extends Controller
{
    // Tampilkan semua rekening
    public function index()
    {
        $accounts = PaymentAccount::all();
        return view('admin.kelola-rekening', compact('accounts'));
    }

    // Simpan rekening baru
    public function store(Request $request)
    {
        $request->validate([
            'method' => 'required|unique:payment_accounts,method',
            'account_number' => 'required',
            'account_name' => 'required',
        ]);

        PaymentAccount::create($request->only('method', 'account_number', 'account_name'));

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil ditambahkan.');
    }

    // Hapus rekening
    public function destroy($id)
    {
        PaymentAccount::findOrFail($id)->delete();

        return redirect()->route('admin.rekening.index')->with('success', 'Rekening berhasil dihapus.');
    }
}
