<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProdukController extends Controller
{
    private $file = 'produk.json';

    // ===================== TAMPIL HALAMAN =====================
    public function index()
    {
        $produkList = [];

        if (File::exists($this->file)) {
            $produkList = json_decode(File::get($this->file));
        }

        return view('admin.kelola_produk', compact('produkList'));
    }

    // ===================== TAMBAH PRODUK =====================
    public function store(Request $request)
    {
        $data = [];

        if (File::exists($this->file)) {
            $data = json_decode(File::get($this->file), true);
        }

        $id = count($data) > 0 ? end($data)['id'] + 1 : 1;

        $gambarPath = null;

        // UPLOAD GAMBAR
        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $namaFile = time() . '_' . $file->getClientOriginalName();

            // simpan ke public/gambar_produk
            $file->move(public_path('gambar_produk'), $namaFile);

            // simpan path ke JSON
            $gambarPath = 'gambar_produk/' . $namaFile;
        }

        $produk = [
            'id' => $id,
            'nama' => $request->nama,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok,
            'deskripsi' => $request->deskripsi,
            'bahan' => $request->bahan,
            'gambar' => $gambarPath
        ];

        $data[] = $produk;

        File::put($this->file, json_encode($data, JSON_PRETTY_PRINT));

        // RETURN KE AJAX (PENTING ADA asset())
        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil ditambahkan',
            'produk' => [
                'id' => $produk['id'],
                'nama' => $produk['nama'],
                'kategori' => $produk['kategori'],
                'harga' => $produk['harga'],
                'stok' => $produk['stok'],
                'deskripsi' => $produk['deskripsi'],
                'bahan' => $produk['bahan'],
                'gambar' => $gambarPath ? asset($gambarPath) : null
            ]
        ]);
    }

    // ===================== UPDATE PRODUK =====================
    public function update(Request $request, $id)
    {
        $data = json_decode(File::get($this->file), true);

        foreach ($data as &$item) {
            if ($item['id'] == $id) {

                $item['nama'] = $request->nama;
                $item['kategori'] = $request->kategori;
                $item['harga'] = $request->harga;
                $item['stok'] = $request->stok;
                $item['deskripsi'] = $request->deskripsi;
                $item['bahan'] = $request->bahan;

                // JIKA ADA GAMBAR BARU
                if ($request->hasFile('gambar')) {
                    $file = $request->file('gambar');
                    $namaFile = time() . '_' . $file->getClientOriginalName();

                    $file->move(public_path('gambar_produk'), $namaFile);

                    $item['gambar'] = 'gambar_produk/' . $namaFile;
                }
            }
        }

        File::put($this->file, json_encode($data, JSON_PRETTY_PRINT));

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil diupdate!',
            'produk' => [
                'id' => $item['id'],
                'nama' => $item['nama'],
                'kategori' => $item['kategori'],
                'harga' => $item['harga'],
                'stok' => $item['stok'],
                'deskripsi' => $item['deskripsi'],
                'bahan' => $item['bahan'],
                'gambar' => $item['gambar'] ? asset($item['gambar']) : null
            ]
        ]);
    }

    // ===================== HAPUS PRODUK =====================
    public function destroy($id)
    {
        $data = json_decode(File::get($this->file), true);

        $data = array_filter($data, function ($item) use ($id) {
            return $item['id'] != $id;
        });

        File::put($this->file, json_encode(array_values($data), JSON_PRETTY_PRINT));

        return response()->json([
            'success' => true,
            'message' => 'Produk berhasil dihapus!'
        ]);
    }

    // ===================== API UNTUK KASIR =====================
    public function list()
    {
        $produk = [];

        if (File::exists($this->file)) {
            $produk = json_decode(File::get($this->file));
        }

        return response()->json([
            'success' => true,
            'produk' => $produk
        ]);
    }
}