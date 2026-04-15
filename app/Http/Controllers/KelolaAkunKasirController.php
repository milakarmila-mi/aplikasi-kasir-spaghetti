<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KelolaAkunKasirController extends Controller
{
    // =========================
    // TAMPILKAN DATA
    // =========================
    public function index()
    {
        $kasir = DB::table('kasir')->get();

        return view('kelola-akun-kasir', compact('kasir'));
    }

    // =========================
    // SIMPAN DATA
    // =========================
   public function store(Request $request)
{
    $request->validate([
        'username' => 'required',
        'password' => 'required'
    ]);

    DB::table('kasir')->insert([
        'username' => $request->username,
        'password' => bcrypt($request->password)
    ]);

    return redirect()->back()->with('success', 'Data kasir berhasil ditambahkan');
}
    // =========================
    // HAPUS DATA
    // =========================
    public function delete($id)
    {
        DB::table('kasir')->where('id', $id)->delete();

        return redirect()->back()->with('success', 'Data kasir berhasil dihapus');
    }
}