<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kasir;
use Illuminate\Support\Facades\File;

class KasirController extends Controller
{
    // ===================== FUNCTION LOG =====================
    private function logActivity($aksi, $kasir)
    {
        $logFile = 'log_activity.json';

        $logs = [];

        if (File::exists($logFile)) {
            $logs = json_decode(File::get($logFile), true);
        }

        $logs[] = [
            'waktu' => now()->format('Y-m-d H:i:s'),
            'aksi' => $aksi,
            'kasir_id' => $kasir->id ?? null,
            'username' => $kasir->username ?? null,
            'keterangan' => $aksi . ' kasir: ' . ($kasir->username ?? '-')
        ];

        File::put($logFile, json_encode($logs, JSON_PRETTY_PRINT));
    }

    // ===================== TAMPIL HALAMAN =====================
    public function index()
    {
        $kasir = Kasir::all();
        return view('kelola_kasir', compact('kasir'));
    }

    // ===================== TAMBAH =====================
    public function store(Request $request)
    {
        $kasir = Kasir::create([
            'username' => $request->username,
            'password' => $request->password
        ]);

        // LOG
        $this->logActivity('Tambah', $kasir);

        return back()->with('success', 'Kasir berhasil ditambahkan');
    }

    // ===================== UPDATE =====================
    public function update(Request $request, $id)
    {
        $kasir = Kasir::find($id);

        if (!$kasir) {
            return back()->with('error', 'Data tidak ditemukan');
        }

        $kasir->update([
            'username' => $request->username,
            'password' => $request->password
        ]);

        // LOG
        $this->logActivity('Update', $kasir);

        return back()->with('success', 'Kasir berhasil diupdate');
    }

    // ===================== HAPUS =====================
    public function destroy($id)
    {
        $kasir = Kasir::find($id);

        if ($kasir) {
            // LOG sebelum dihapus
            $this->logActivity('Hapus', $kasir);

            $kasir->delete();
        }

        return back()->with('success', 'Kasir berhasil dihapus');
    }
}