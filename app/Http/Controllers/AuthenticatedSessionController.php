<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function destroy(Request $request)
    {
        Auth::logout(); // logout user

        $request->session()->invalidate(); // hapus session
        $request->session()->regenerateToken(); // keamanan

        return redirect()->route('login'); // ⬅️ ke login.blade.php
    }
}