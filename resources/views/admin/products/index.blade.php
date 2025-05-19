@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Daftar Produk</h1>

    <a href="{{ route('admin.products.create') }}" class="inline-block bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded mb-6">
        + Tambah Produk
    </a>

    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-gray-200 rounded-lg">
            <thead class="bg-pink-100">
                <tr>
                    <th class="py-3 px-4 border-b text-left">#</th>
                    <th class="py-3 px-4 border-b text-left">Gambar</th> <!-- Tambahkan ini -->
                    <th class="py-3 px-4 border-b text-left">Nama</th>
                    <th class="py-3 px-4 border-b text-left">Deskripsi</th>
                    <th class="py-3 px-4 border-b text-left">Harga</th>
                    <th class="py-3 px-4 border-b text-left">Stok</th>
                    <th class="py-3 px-4 border-b text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>

                        <!-- Kolom Gambar -->
                        <td class="py-2 px-4 border-b">
                            @if($product->gambar)
                                <img src="{{ asset('images/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-16 h-16 object-cover">
                            @else
                                <span class="text-gray-400 italic">No Image</span>
                            @endif
                        </td>

                        <!-- Kolom Nama -->
                        <td class="py-2 px-4 border-b">{{ $product->nama }}</td>

                        <td class="py-2 px-4 border-b">{{ $product->deskripsi }}</td>
                        <td class="py-2 px-4 border-b">Rp {{ number_format($product->harga, 2, ',', '.') }}</td>
                        <td class="py-2 px-4 border-b">{{ $product->stok }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.products.edit', $product->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded"
                                            onclick="return confirm('Yakin ingin menghapus produk ini?')">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-4 px-4 text-center text-gray-500">Belum ada produk.</td> <!-- Sesuaikan colspan jadi 7 -->
                    </tr>
                @endforelse
            </tbody>


        </table>
    </div>
</div>
@endsection
