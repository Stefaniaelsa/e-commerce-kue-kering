@extends('layouts.app')

@section('content')
    <div class="p-8">
        <h1 class="text-2xl font-bold mb-6">Daftar Pesanan</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 bg-white">
                <thead class="bg-pink-100">
                    <tr>
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Nama Pembeli</th>
                        <th class="p-2 border">Total Harga</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Metode</th>
                        <th class="p-2 border">Pengiriman</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border">{{ $orders->firstItem() + $loop->index }}</td>
                            <td class="p-2 border">{{ $order->user->nama ?? '-' }}</td>
                            <td class="p-2 border">Rp{{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td class="p-2 border">
                                <span
                                    class="px-2 py-1 rounded text-sm 
                                @if ($order->status == 'menunggu') bg-yellow-100 text-yellow-700
                                @elseif($order->status == 'diproses') bg-blue-100 text-blue-700
                                @elseif($order->status == 'selesai') bg-green-100 text-green-700
                                @elseif($order->status == 'dibatalkan') bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="p-2 border">{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('d/m/Y H:i') }}
                            </td>
                            <td class="p-2 border">{{ ucfirst($order->metode_pembayaran) }}</td>
                            <td class="p-2 border">{{ ucfirst($order->pengiriman) }}</td>
                            <td class="p-2 border space-x-2">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                    class="inline-block bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm">
                                    Detail
                                </a>

                                <!-- Dropdown untuk Update Status -->
                                <div class="inline-block relative">
                                    <select onchange="updateStatus({{ $order->id }}, this.value)"
                                        class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded text-sm cursor-pointer">
                                        <option value="">Update Status</option>
                                        @if ($order->status == 'menunggu')
                                            <option value="diproses">Proses Pesanan</option>
                                            <option value="dibatalkan">Batalkan</option>
                                        @elseif($order->status == 'diproses')
                                            <option value="selesai">Selesaikan</option>
                                            <option value="dibatalkan">Batalkan</option>
                                        @elseif($order->status == 'selesai')
                                            <option value="diproses">Kembalikan ke Diproses</option>
                                        @elseif($order->status == 'dibatalkan')
                                            <option value="menunggu">Kembalikan ke Menunggu</option>
                                        @endif
                                    </select>
                                </div>

                                <!-- Form tersembunyi untuk update status -->
                                <form id="update-status-form-{{ $order->id }}"
                                    action="{{ route('admin.orders.update', $order->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" id="status-input-{{ $order->id }}">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="p-4 text-center text-gray-500">Belum ada pesanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $orders->links() }}
        </div>
    </div>

    <script>
        function updateStatus(orderId, newStatus) {
            if (newStatus === '') return;

            if (confirm('Yakin ingin mengubah status pesanan ini?')) {
                document.getElementById('status-input-' + orderId).value = newStatus;
                document.getElementById('update-status-form-' + orderId).submit();
            } else {
                // Reset dropdown jika dibatalkan
                event.target.selectedIndex = 0;
            }
        }
    </script>
@endsection
