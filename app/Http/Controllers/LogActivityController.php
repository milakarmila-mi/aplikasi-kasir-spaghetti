<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LogActivityController extends Controller
{
    public function index()
    {
        $logs = [
            ['waktu' => '2026-03-30 10:00', 'aktivitas' => 'Menambahkan produk', 'user' => 'Admin'],
            ['waktu' => '2026-03-30 11:00', 'aktivitas' => 'Edit produk', 'user' => 'Admin'],
            ['waktu' => '2026-03-30 12:00', 'aktivitas' => 'Transaksi berhasil', 'user' => 'Kasir'],
        ];

        // ✅ PERBAIKAN DI SINI
        return view('admin.log_activity', compact('logs'));
    }
}