<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function index()
    {
        // Ambil user yang sedang login
        $user = Auth::user();

        // Jika belum menggunakan sistem login, bisa diganti:
        // $user = User::first();

        return view('profil', compact('user'));
    }
}
