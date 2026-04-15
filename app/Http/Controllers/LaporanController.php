<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function laporan()
    {
        // pastikan file blade resources/views/admin/laporan.blade.php ada
        return view('admin.laporan');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }
}