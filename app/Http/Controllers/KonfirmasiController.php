<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KonfirmasiPembayaran;

class KonfirmasiPembayaranController extends Controller
{
    /**
     * Menampilkan daftar konfirmasi pembayaran.
     */
    public function index()
    {
        $konfirmasis = KonfirmasiPembayaran::orderBy('created_at', 'desc')->get();
        return view('konfirmasi.index', compact('konfirmasis'));
    }

    /**
     * Menampilkan detail konfirmasi pembayaran tertentu (opsional).
     */
    public function show($id)
    {
        $konfirmasi = KonfirmasiPembayaran::findOrFail($id);
        return view('konfirmasi.show', compact('konfirmasi'));
    }

    /**
     * Update status konfirmasi (misalnya: disetujui / ditolak).
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,disetujui,ditolak',
        ]);

        $konfirmasi = KonfirmasiPembayaran::findOrFail($id);
        $konfirmasi->status = $request->status;
        $konfirmasi->save();

        return redirect()->route('konfirmasi.index')->with('success', 'Status berhasil diperbarui.');
    }
}
