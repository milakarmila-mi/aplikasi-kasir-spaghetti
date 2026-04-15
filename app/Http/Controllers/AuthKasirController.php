<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AuthKasirController extends Controller
{
    // =========================
    // TAMPILKAN LOGIN
    // =========================
    public function showLogin()
    {
        if (session()->has('kasir')) {
            return redirect('/');
        }

        return view('login');
    }

    // =========================
    // PROSES LOGIN
    // =========================
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        $kasir = DB::table('kasir')
            ->where('username', $request->username)
            ->first();

        // ✅ CEK PASSWORD HASH
        if ($kasir && Hash::check($request->password, $kasir->password)) {

            session(['kasir' => $kasir->username]);

            // 🔥 MASUK KE INDEX (HALAMAN KASIR)
            return redirect()->route('index');
        }

        return back()->with('error', 'Username atau Password salah');
    }

    // =========================
    // HALAMAN UTAMA (INDEX)
    // =========================
    public function index()
    {
        if (!session()->has('kasir')) {
            return redirect()->route('login');
        }

        // ambil produk untuk ditampilkan di index.blade.php kamu
        $menus = DB::table('produk')->get();

        return view('index', compact('menus'));
    }

    // =========================
    // LOGOUT
    // =========================
    public function logout()
    {
        session()->forget('kasir');
        return redirect()->route('login');
    }
}