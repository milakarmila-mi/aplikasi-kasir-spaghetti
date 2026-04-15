<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $admin = DB::table('admins')
            ->where('username', $request->username)
            ->where('password', $request->password) // tanpa hash
            ->first();

        if ($admin) {
            session(['admin_logged_in' => true]);
            return redirect('/admin/dashboard');
        } else {
            return back()->with('error', 'Username atau password salah');
        }
    }

    public function logout()
    {
        session()->forget('admin_logged_in');
        return redirect('/admin/login');
    }
}
