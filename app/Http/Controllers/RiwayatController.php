<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil data riwayat dari session
        $riwayat = session()->get('riwayat', []);
        
        // Jika belum ada data, buat data contoh
        if (empty($riwayat)) {
            $riwayat = [
                [
                    'id' => 1,
                    'tanggal' => '2024-03-20 10:30:00',
                    'keterangan' => 'Pembelian Nasi Goreng x2, Es Teh x2',
                    'jumlah' => 4,
                    'total' => 85000
                ],
                [
                    'id' => 2,
                    'tanggal' => '2024-03-19 14:15:00',
                    'keterangan' => 'Pembelian Mie Ayam x1, Es Jeruk x1',
                    'jumlah' => 2,
                    'total' => 35000
                ],
                [
                    'id' => 3,
                    'tanggal' => '2024-03-18 19:45:00',
                    'keterangan' => 'Pembelian Ayam Goreng x3, Nasi Putih x3, Es Teh x3',
                    'jumlah' => 9,
                    'total' => 120000
                ],
                [
                    'id' => 4,
                    'tanggal' => '2024-03-17 12:00:00',
                    'keterangan' => 'Pembelian Sate Ayam x5, Es Jeruk x5',
                    'jumlah' => 10,
                    'total' => 150000
                ],
                [
                    'id' => 5,
                    'tanggal' => '2024-03-16 08:30:00',
                    'keterangan' => 'Pembelian Bubur Ayam x2, Kopi x2',
                    'jumlah' => 4,
                    'total' => 50000
                ]
            ];
            
            // Simpan data contoh ke session
            session()->put('riwayat', $riwayat);
        }
        
        // Kirim data ke view
        return view('riwayat', compact('riwayat'));
    }
    
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'total' => 'required|integer|min:0'
        ]);
        
        // Ambil data riwayat yang sudah ada
        $riwayat = session()->get('riwayat', []);
        
        // Buat ID baru
        $newId = count($riwayat) > 0 ? max(array_column($riwayat, 'id')) + 1 : 1;
        
        // Buat data baru
        $newOrder = [
            'id' => $newId,
            'tanggal' => now()->format('Y-m-d H:i:s'),
            'keterangan' => $request->keterangan,
            'jumlah' => $request->jumlah,
            'total' => $request->total
        ];
        
        // Tambahkan ke array
        $riwayat[] = $newOrder;
        
        // Simpan ke session
        session()->put('riwayat', $riwayat);
        
        // Redirect dengan pesan sukses
        return redirect()
            ->route('riwayat')
            ->with('success', 'Riwayat berhasil ditambahkan!');
    }
    
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'keterangan' => 'required|string|max:255',
            'jumlah' => 'required|integer|min:1',
            'total' => 'required|integer|min:0'
        ]);
        
        // Ambil data riwayat dari session
        $riwayat = session()->get('riwayat', []);
        
        // Cari dan update data
        $updated = false;
        foreach ($riwayat as $key => $data) {
            if ($data['id'] == $id) {
                $riwayat[$key] = [
                    'id' => $id,
                    'tanggal' => $data['tanggal'], // tanggal tetap
                    'keterangan' => $request->keterangan,
                    'jumlah' => $request->jumlah,
                    'total' => $request->total
                ];
                $updated = true;
                break;
            }
        }
        
        // Jika tidak ditemukan
        if (!$updated) {
            return redirect()
                ->route('riwayat')
                ->with('error', 'Data riwayat tidak ditemukan!');
        }
        
        // Simpan kembali ke session
        session()->put('riwayat', $riwayat);
        
        // Redirect dengan pesan sukses
        return redirect()
            ->route('riwayat')
            ->with('success', 'Riwayat berhasil diupdate!');
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Ambil data riwayat dari session
        $riwayat = session()->get('riwayat', []);
        
        // Cari dan hapus data
        $deleted = false;
        foreach ($riwayat as $key => $data) {
            if ($data['id'] == $id) {
                unset($riwayat[$key]);
                $deleted = true;
                break;
            }
        }
        
        // Jika tidak ditemukan
        if (!$deleted) {
            return redirect()
                ->route('riwayat')
                ->with('error', 'Data riwayat tidak ditemukan!');
        }
        
        // Reindex array
        $riwayat = array_values($riwayat);
        
        // Simpan kembali ke session
        session()->put('riwayat', $riwayat);
        
        // Redirect dengan pesan sukses
        return redirect()
            ->route('riwayat')
            ->with('success', 'Riwayat berhasil dihapus!');
    }
    
    /**
     * Clear all riwayat data
     */
    public function clear()
    {
        // Hapus semua data riwayat dari session
        session()->forget('riwayat');
        
        return redirect()
            ->route('riwayat')
            ->with('success', 'Semua data riwayat berhasil dihapus!');
    }
    
    /**
     * Add sample data
     */
    public function addSample()
    {
        // Data contoh baru
        $sampleData = [
            [
                'id' => 6,
                'tanggal' => date('Y-m-d H:i:s'),
                'keterangan' => 'Pembelian Sample Data',
                'jumlah' => 3,
                'total' => 75000
            ]
        ];
        
        // Ambil data yang ada
        $riwayat = session()->get('riwayat', []);
        
        // Gabungkan data
        $riwayat = array_merge($riwayat, $sampleData);
        
        // Simpan ke session
        session()->put('riwayat', $riwayat);
        
        return redirect()
            ->route('riwayat')
            ->with('success', 'Data sampel berhasil ditambahkan!');
    }
}