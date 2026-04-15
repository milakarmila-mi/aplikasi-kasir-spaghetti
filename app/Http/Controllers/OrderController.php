<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    // Menampilkan detail order
    public function show($id)
    {
        // Ambil order beserta relasi details
        $order = Order::with('details')->find($id);

        if (!$order) {
            return redirect()->back()->with('error', 'Order tidak ditemukan.');
        }

        // Mapping data detail supaya mudah dipakai di Blade
        $details = $order->details->map(function($item) {
            return [
                'nama' => $item->nama_menu,
                'jumlah' => $item->jumlah,
                'harga' => $item->harga
            ];
        });

        // Kirim ke view resources/views/detail.blade.php
        return view('detail', compact('order', 'details'));
    }
}