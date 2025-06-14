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
        $order = Order::where('user_id', Auth::id())->orderBy('id', 'desc')->first();
        return view('pembayaran', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'bukti_transfer' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'bank_asal' => 'required|string|max:255',
        ]);

        try {
           if ($request->hasFile('bukti_transfer')) {
            $user = Auth::user();
            $order = Order::where('user_id', $user->id)->firstOrFail();

            // Upload dan ambil path penyimpanan
            $buktiTransfer = $request->file('bukti_transfer');
            $path = $this->fileUploadService->uploadBuktiTransfer($buktiTransfer); // sudah hasil 'bukti_transfer/2025/06/14/namafile.png'

            // Simpan path lengkap ke database
            Pembayarans::create([
                'order_id' => $order->id,
                'bank_asal' => $request->input('bank_asal'),
                'bukti_transfer' => $path, // simpan path lengkap
        ]);

            return redirect()->route('pembayaran')->with('success', 'Pembayaran berhasil dilakukan. Silahkan tunggu konfirmasi dari admin.');


        }
        
        } catch (\Exception $e) {
            \Log::error('Error proses pembayaran: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan sistem. Silakan coba lagi atau hubungi admin.');
        }
    }
}
