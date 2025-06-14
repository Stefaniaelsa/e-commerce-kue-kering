@extends('layouts.app')

@section('content')
    <div class="p-8">
        <h1 class="text-2xl font-bold mb-6">Daftar Pembayaran</h1>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="w-full border border-gray-200 bg-white">
                <thead class="bg-blue-100">
                    <tr>
                        <th class="p-2 border">#</th>
                        <th class="p-2 border">Order ID</th>
                        <th class="p-2 border">Bank Asal</th>
                        <th class="p-2 border">Bukti Transfer</th>
                        <th class="p-2 border">Status</th>
                        <th class="p-2 border">Tanggal</th>
                        <th class="p-2 border">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pembayarans as $pembayaran)
                        <tr class="hover:bg-gray-50">
                            <td class="p-2 border">{{ $loop->iteration }}</td>
                            <td class="p-2 border">{{ $pembayaran->order_id }}</td>
                            <td class="p-2 border">{{ $pembayaran->bank_asal ?? '-' }}</td>
                            <td class="p-2 border">
                                @if ($pembayaran->bukti_transfer)
                                  <a href="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" target="_blank" class="text-blue-600 underline">
                                        Lihat Bukti
                                  </a>

                                @else
                                    Tidak Ada
                                @endif
                            </td>
                            <td class="p-2 border">
                                <span class="px-2 py-1 rounded text-sm 
                                    @if ($pembayaran->status == 'menunggu') bg-yellow-100 text-yellow-700
                                    @elseif($pembayaran->status == 'diterima') bg-green-100 text-green-700
                                    @elseif($pembayaran->status == 'ditolak') bg-red-100 text-red-700 @endif">
                                    {{ ucfirst($pembayaran->status) }}
                                </span>
                            </td>
                            <td class="p-2 border">{{ \Carbon\Carbon::parse($pembayaran->created_at)->format('d/m/Y H:i') }}</td>
                            <td class="p-2 border space-x-2">
                                <div class="inline-block relative">
                                    <select onchange="updateStatus({{ $pembayaran->id }}, this.value)"
                                        class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded text-sm cursor-pointer">
                                        <option value="">Update Status</option>
                                        @if ($pembayaran->status == 'menunggu')
                                            <option value="diterima">Terima</option>
                                            <option value="ditolak">Tolak</option>
                                        @elseif($pembayaran->status == 'diterima')
                                            <option value="menunggu">Kembalikan ke Menunggu</option>
                                            <option value="ditolak">Tolak</option>
                                        @elseif($pembayaran->status == 'ditolak')
                                            <option value="menunggu">Kembalikan ke Menunggu</option>
                                            <option value="diterima">Terima</option>
                                        @endif
                                    </select>
                                </div>

                                <!-- Form tersembunyi -->
                                <form id="update-status-form-{{ $pembayaran->id }}"
                                    action="{{ route('admin.pembayarans.update', $pembayaran->id) }}" method="POST"
                                    style="display: none;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status" id="status-input-{{ $pembayaran->id }}">
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="p-4 text-center text-gray-500">Belum ada data pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script>
        function updateStatus(pembayaranId, newStatus) {
            if (newStatus === '') return;

            if (confirm('Yakin ingin mengubah status pembayaran ini?')) {
                document.getElementById('status-input-' + pembayaranId).value = newStatus;
                document.getElementById('update-status-form-' + pembayaranId).submit();
            } else {
                event.target.selectedIndex = 0;
            }
        }
    </script>
@endsection
