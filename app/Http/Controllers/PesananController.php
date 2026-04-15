<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PesananController extends Controller
{
    public function simpan(Request $request)
    {
        try {

            $request->validate([
                'id_pelanggan' => 'required',
                'detail' => 'required|array',
                'total_harga' => 'required|numeric'
            ]);

            DB::table('pesanans')->insert([
                'id_pelanggan' => $request->id_pelanggan,
                'detail' => json_encode($request->detail),
                'total_harga' => $request->total_harga,
                'created_at' => now(),
                'updated_at' => now()
            ]);

            return response()->json([
                'redirect' => route('order')
            ]);

        } catch (\Exception $e) {

            return response()->json([
                'message' => $e->getMessage()
            ]);
        }
    }

    public function order()
    {
        $order = DB::table('pesanans')
                    ->orderBy('created_at','desc')
                    ->first();

        if (!$order) {
            return "Belum ada pesanan.";
        }

        $details = json_decode($order->detail, true);

        return view('order', compact('order','details'));
    }
}