<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Admin;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $admin = Admin::where('username', $request->username)->first();

        if (!$admin || $admin->password !== $request->password) {
            return back()->with('error', 'Username atau password salah');
        }

        // Simpan session manual jika tidak pakai auth
        session(['admin_logged_in' => true]);
        return redirect('/admin/dashboard');
    }
}
