<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayarans;

class PembayaranController extends Controller
{
    public function index()
    {
        $pembayarans = Pembayarans::with('order.user')->paginate(10);
        return view('admin.pembayaran.index', compact('pembayarans'));
    }

   public function update(Request $request, $id)
    {
        $pembayaran = \App\Models\Pembayaran::findOrFail($id);

        $request->validate([
            'status' => 'required|in:menunggu,diterima,ditolak',
        ]);

        $pembayaran->status = $request->status;
        $pembayaran->save();

        return redirect()->route('admin.pembayaran.index')->with('success', 'Status pembayaran berhasil diperbarui.');
    }

}
