<?php

namespace App\Http\Controllers;

use App\Models\Pembayarans;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Pembayaran;
use Illuminate\Support\Facades\Auth;
use App\Services\FileUploadService;

class PembayaranController extends Controller
{
    protected $fileUploadService;

    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }

    public function show()
    {
        $order = Order::where('user_id', Auth::id())
            ->where('status', 'menunggu')
            ->where('metode_pembayaran', 'transfer')
            ->orderBy('id', 'desc')
            ->first();

        if (!$order) {
            return redirect()->route('beranda')
                ->with('error', 'Tidak ada pesanan yang perlu dibayar.');
        }

        // Cek apakah pesanan sudah expired
        if ($order->isExpired()) {
            $order->checkAndUpdateExpired();
            return redirect()->route('profil')
                ->with('error', 'Pesanan telah dibatalkan karena melewati batas waktu pembayaran (24 jam).');
        }

        return view('pembayaran', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank_asal' => 'required|string|max:255',
        ]);

        try {
            $order = Order::where('user_id', Auth::id())
                ->where('status', 'menunggu')
                ->where('metode_pembayaran', 'transfer')
                ->orderBy('id', 'desc')
                ->first();

            if (!$order) {
                return redirect()->route('profil')
                    ->with('error', 'Pesanan tidak ditemukan atau sudah tidak valid.');
            }

            // Cek apakah pesanan sudah expired
            if ($order->checkAndUpdateExpired()) {;
                return redirect()->route('profil')
                    ->with('error', 'Pesanan telah dibatalkan karena melewati batas waktu pembayaran (24 jam).');
            }

            // $remainingTime = $order->getRemainingTime();
            // $expired = $order->checkAndUpdateExpired();
            // return response()->json("waktu" . $remainingTime . " expired: " . $expired);
            
            // Cek apakah sudah ada pembayaran untuk pesanan ini
            $existingPayment = Pembayarans::where('order_id', $order->id)->first();
            if ($existingPayment) {
                return redirect()->route('profil')
                    ->with('error', 'Pembayaran untuk pesanan ini sudah pernah diunggah.');
            }

            if ($request->hasFile('bukti_transfer')) {
                $buktiTransfer = $request->file('bukti_transfer');
                $path = $this->fileUploadService->uploadBuktiTransfer($buktiTransfer);

                Pembayarans::create([
                    'order_id' => $order->id,
                    'bank_asal' => $request->input('bank_asal'),
                    'bukti_transfer' => $path,
                ]);

                return redirect()->route('profil')
                    ->with('success', 'Pembayaran berhasil diunggah. Silakan tunggu konfirmasi dari admin.');
            }

            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat mengunggah bukti transfer.');
        } catch (\Exception $e) {
            \Log::error('Error proses pembayaran: ' . $e->getMessage());
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.');
        }
    }
}
