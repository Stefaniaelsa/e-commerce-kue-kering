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

   // Admin\PembayaranController.php
    public function update(Request $request, $id)
{
    $pembayaran = Pembayarans::findOrFail($id);
    $pembayaran->status = $request->status;
    $pembayaran->save();

    $order = $pembayaran->order;

    if ($request->status === 'diterima') {
        if ($order->status === 'menunggu') {
            $order->status = 'diproses';
            $order->save();
        }
    } elseif ($request->status === 'ditolak') {
        if ($order->status === 'menunggu') {
            $order->status = 'batalkan';
            $order->save();
        }
    }

    return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
}

public function show($id)
{
    abort(405, 'Method Not Allowed');
}


}
