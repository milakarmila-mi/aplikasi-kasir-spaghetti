<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Data bisa diambil dari DB, contoh hardcode:
        $totalProduk = 120;
        $totalTransaksi = 350;
        $pendapatan = 50000000;

        $transaksiBulanan = [30, 45, 60, 80, 75, 90, 110, 95, 85, 100, 120, 130];
        $kasirStats = [120, 90, 140];
        $topProducts = ['Spaghetti Carbonara', 'Spaghetti Aglio', 'Spaghetti Primavera'];
        $topProductsSales = [120, 95, 80];

        return view('dashboard', compact(
            'totalProduk',
            'totalTransaksi',
            'pendapatan',
            'transaksiBulanan',
            'kasirStats',
            'topProducts',
            'topProductsSales'
        ));
    }
}