<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Keranjang;
use App\Models\Item_Keranjang;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    public function index()
    {
        $keranjang = Keranjang::where('user_id', Auth::id())
            ->where('status', 'keranjang')
            ->first();

        $cartItems = $keranjang ? $keranjang->Item_Keranjang()->with('varian.produk')->get() : collect();

        return view('keranjang', compact('cartItems', 'keranjang'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_varian' => 'required|exists:product_variants,id',
            'jumlah' => 'required|integer|min:1',
        ]);

        $varian = ProductVariant::findOrFail($request->id_varian);

        // ✅ Cek stok cukup
        if ($request->jumlah > $varian->stok) {
            return redirect()->back()->with('error', 'Stok tidak mencukupi untuk jumlah yang diminta.');
        }

        $harga = $varian->harga;
        $subTotal = $harga * $request->jumlah;
        $userId = Auth::id();

        $keranjang = Keranjang::firstOrCreate(
            ['user_id' => $userId, 'status' => 'keranjang'],
            ['total_harga' => 0, 'total_produk' => 0]
        );

        $item = Item_Keranjang::where('id_keranjang', $keranjang->id)
            ->where('id_varian', $request->id_varian)
            ->first();

        if ($item) {
            $totalJumlahBaru = $item->jumlah + $request->jumlah;
            if ($totalJumlahBaru > $varian->stok) {
                return redirect()->back()->with('error', 'Stok tidak cukup untuk menambahkan item sebanyak itu.');
            }

            $item->jumlah = $totalJumlahBaru;
            $item->harga = $totalJumlahBaru * $harga;
            $item->save();
        } else {
            Item_Keranjang::create([
                'id_keranjang' => $keranjang->id,
                'id_varian' => $request->id_varian,
                'jumlah' => $request->jumlah,
                'harga' => $subTotal,
            ]);
        }

        $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
        $keranjang->total_produk = $keranjang->Item_Keranjang()->count('id_varian');
        session(['total-produk' => $keranjang->total_produk]);
        $keranjang->save();

        $varian->stok -= $request->jumlah;
        $varian->save();

        return redirect()->back()->with('success', 'Produk berhasil ditambahkan ke keranjang.');
    }

    public function destroy($id)
    {
        $item = Item_Keranjang::findOrFail($id);
        $keranjang = $item->keranjang;

        // ✅ Kembalikan stok
        $varian = ProductVariant::findOrFail($item->id_varian);
        $varian->stok += $item->jumlah;
        $varian->save();

        $item->delete();

        $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
        $keranjang->total_produk = $keranjang->Item_Keranjang()->count('id_varian');
        session(['total-produk' => $keranjang->total_produk]);
        $keranjang->save();

        return redirect()->route('cart.index')->with('success', 'Item berhasil dihapus dan stok dikembalikan.');
    }

    public function update(Request $request, $id)
    {
        $item = Item_Keranjang::findOrFail($id);
        $oldJumlah = $item->jumlah;

        if ($request->has('action')) {
            if ($request->action === 'increase') {
                $item->jumlah += 1;
            } elseif ($request->action === 'decrease' && $item->jumlah > 1) {
                $item->jumlah -= 1;
            }
        } elseif ($request->has('jumlah')) {
            $item->jumlah = max(1, (int) $request->jumlah);
        }

        $diffJumlah = $item->jumlah - $oldJumlah;

        $varian = ProductVariant::findOrFail($item->id_varian);

        // ✅ Cek jika stok cukup saat update naik
        if ($diffJumlah > 0 && $diffJumlah > $varian->stok) {
            return back()->with('error', 'Stok tidak mencukupi untuk update jumlah item.');
        }

        $item->harga = $item->jumlah * $varian->harga;
        $item->save();

        // ✅ Update stok
        $varian->stok -= $diffJumlah;
        $varian->save();

        $keranjang = $item->keranjang;
        $keranjang->total_harga = $keranjang->Item_Keranjang()->sum('harga');
        $keranjang->total_produk = $keranjang->Item_Keranjang()->count('id_varian');
        session(['total-produk' => $keranjang->total_produk]);
        $keranjang->save();

        return back()->with('success', 'Keranjang diperbarui dan stok disesuaikan');
    }

    public function checkout(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'alamat' => 'required|string',
            'pengiriman' => 'required|in:gojek,ambil ditempat',
            'catatan' => 'nullable|string',
        ]);

        $keranjang = Keranjang::where('user_id', $user->id)
            ->where('status', 'keranjang')
            ->with('Item_Keranjang')
            ->first();

        if (!$keranjang || $keranjang->Item_Keranjang->isEmpty()) {
            return back()->with('error', 'Keranjang kosong.');
        }

        DB::beginTransaction();

        try {
            $order = Order::create([
                'user_id' => $user->id,
                'total_harga' => $keranjang->total_harga,
                'status' => 'menunggu',
                'alamat_pengiriman' => $request->alamat,
                'pengiriman' => $request->pengiriman,
                'catatan' => $request->catatan,
            ]);

            foreach ($keranjang->Item_Keranjang as $item) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'varian_id' => $item->id_varian,
                    'jumlah' => $item->jumlah,
                    'harga' => $item->harga,
                ]);
            }

            $keranjang->update(['status' => 'selesai']);
            session(['total-produk' => 0]);

            DB::commit();

            return redirect()->route('orders.show', $order->id)
                ->with('success', 'Pesanan berhasil dibuat.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }
    }
}
