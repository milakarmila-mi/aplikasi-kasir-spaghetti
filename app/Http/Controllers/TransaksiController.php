<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    // Menampilkan halaman kasir/pembayaran
    public function kasir($id)
    {
        // Ambil data order berdasarkan id
        $order = DB::table('orders')->where('id', $id)->first();
        
        if (!$order) {
            return redirect('/dashboard')->with('error', 'Order tidak ditemukan!');
        }
        
        // Ambil detail order dengan join ke menu
        $details = DB::table('order_details')
                    ->join('menus', 'order_details.id_menu', '=', 'menus.id')
                    ->where('order_details.id_order', $id)
                    ->select('order_details.*', 'menus.nama', 'menus.harga')
                    ->get();
        
        return view('kasir', compact('order', 'details'));
    }
    
    // Menyimpan transaksi dan redirect ke struk
    public function simpanTransaksi(Request $request)
    {
        try {
            DB::beginTransaction();
            
            // Simpan data transaksi ke tabel transaksi
            $id_transaksi = DB::table('transaksis')->insertGetId([
                'id_pelanggan' => $request->id_pelanggan,
                'total_harga' => $request->total_harga,
                'bayar' => $request->bayar,
                'kembalian' => $request->bayar - $request->total_harga,
                'tanggal' => now(),
                'created_at' => now(),
                'updated_at' => now()
            ]);
            
            // Ambil detail order berdasarkan id_pelanggan
            $orderDetails = DB::table('order_details')
                            ->join('menus', 'order_details.id_menu', '=', 'menus.id')
                            ->where('order_details.id_pelanggan', $request->id_pelanggan)
                            ->where('order_details.status', 'pending')
                            ->select('order_details.*', 'menus.harga as menu_harga')
                            ->get();
            
            // Simpan detail transaksi
            foreach($orderDetails as $detail) {
                DB::table('detail_transaksis')->insert([
                    'id_transaksi' => $id_transaksi,
                    'id_menu' => $detail->id_menu,
                    'jumlah' => $detail->jumlah,
                    'harga' => $detail->menu_harga,
                    'subtotal' => $detail->jumlah * $detail->menu_harga,
                    'created_at' => now(),
                    'updated_at' => now()
                ]);
                
                // Update status order detail menjadi selesai
                DB::table('order_details')
                    ->where('id', $detail->id)
                    ->update(['status' => 'selesai']);
            }
            
            DB::commit();
            
            // Redirect ke halaman struk
            return redirect()->route('struk', $id_transaksi);
            
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }
    
    // Menampilkan halaman struk
    public function struk($id)
    {
        // Ambil data transaksi
        $transaksi = DB::table('transaksis')->where('id', $id)->first();
        
        if (!$transaksi) {
            return redirect('/riwayat')->with('error', 'Transaksi tidak ditemukan!');
        }
        
        // Ambil detail transaksi dengan join ke menu
        $detailTransaksi = DB::table('detail_transaksis')
                            ->join('menus', 'detail_transaksis.id_menu', '=', 'menus.id')
                            ->where('detail_transaksis.id_transaksi', $id)
                            ->select('detail_transaksis.*', 'menus.nama')
                            ->get();
        
        return view('struk', compact('transaksi', 'detailTransaksi'));
    }
    
    // Menampilkan riwayat transaksi
    public function riwayat()
    {
        $transaksis = DB::table('transaksis')
                        ->orderBy('tanggal', 'desc')
                        ->get();
        
        return view('riwayat', compact('transaksis'));
    }
}