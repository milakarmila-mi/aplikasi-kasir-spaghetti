<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // TOTAL PRODUK
        $totalProduk = DB::table('produk')->count();

        // PESANAN HARI INI
        $pesananHariIni = DB::table('pesanans')
            ->whereDate('created_at', date('Y-m-d'))
            ->count();

        // PENDAPATAN HARI INI
        $pendapatanHariIni = DB::table('pesanans')
            ->whereDate('created_at', date('Y-m-d'))
            ->sum('total_harga');

        // DATA GRAFIK PENJUALAN (last 7 days)
        $penjualanPerHari = DB::table('pesanans')
            ->selectRaw('DATE(created_at) as tanggal, SUM(total_harga) as total')
            ->whereDate('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('tanggal')
            ->orderBy('tanggal', 'asc')
            ->get()
            ->map(function ($item) {
                return [
                    'tanggal' => Carbon::parse($item->tanggal)->format('d/m'),
                    'total' => $item->total
                ];
            })
            ->toArray();

        return view('admin.dashboard', compact(
            'totalProduk',
            'pesananHariIni',
            'pendapatanHariIni',
            'penjualanPerHari'
        ));
    }
}