<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $username = $request->input('username');
        $password = $request->input('password');

        // Contoh validasi manual sederhana
        if ($username === 'admin' && $password === 'password123') {
            // Simpan session login
            session(['admin_logged_in' => true]);
            return redirect('/admin');
        }

        return redirect('/login')->with('error', 'Username atau password salah');
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect('/login');
    }
}