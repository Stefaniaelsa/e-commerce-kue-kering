@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-2xl font-bold mb-4">Daftar Konfirmasi Pembayaran</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded shadow">
            <thead class="bg-gray-100 text-left">
                <tr>
                    <th class="px-4 py-2 border-b">ID</th>
                    <th class="px-4 py-2 border-b">Order ID</th>
                    <th class="px-4 py-2 border-b">Metode</th>
                    <th class="px-4 py-2 border-b">Bukti Transfer</th>
                    <th class="px-4 py-2 border-b">Status</th>
                    <th class="px-4 py-2 border-b">Dibuat</th>
                    <th class="px-4 py-2 border-b">Diperbarui</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($konfirmasis as $konfirmasi)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border-b">{{ $konfirmasi->id }}</td>
                    <td class="px-4 py-2 border-b">{{ $konfirmasi->order_id }}</td>
                    <td class="px-4 py-2 border-b">{{ $konfirmasi->metode }}</td>
                    <td class="px-4 py-2 border-b">
                        @if($konfirmasi->bukti_transfer)
                            <a href="{{ asset('storage/bukti/' . $konfirmasi->bukti_transfer) }}" target="_blank" class="text-blue-500 underline">Lihat</a>
                        @else
                            <span class="text-gray-400 italic">Belum ada</span>
                        @endif
                    </td>
                    <td class="px-4 py-2 border-b">
                        <span class="px-2 py-1 rounded text-white text-sm {{ $konfirmasi->status == 'diterima' ? 'bg-green-500' : ($konfirmasi->status == 'ditolak' ? 'bg-red-500' : 'bg-yellow-500') }}">
                            {{ ucfirst($konfirmasi->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-2 border-b">{{ $konfirmasi->created_at->format('d M Y H:i') }}</td>
                    <td class="px-4 py-2 border-b">{{ $konfirmasi->updated_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center text-gray-500 py-4">Belum ada data konfirmasi pembayaran.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
