<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasir;

class AdminKasirController extends Controller
{
    public function index()
    {
        $kasirList = Kasir::all();
        return view('manajemen-kasir', compact('kasirList'));
    }

    public function store(Request $request)
    {
        Kasir::create([
            'nama' => $request->nama,
            // tambahkan field lain kalau perlu
        ]);
    }
}