@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Edit Produk</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama" class="block text-lg font-medium mb-2">Nama Produk</label>
            <input type="text" id="nama" name="nama" class="w-full border-gray-300 p-2 rounded-md" value="{{ old('nama', $product->nama) }}" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-lg font-medium mb-2">Deskripsi Produk</label>
            <textarea id="deskripsi" name="deskripsi" class="w-full border-gray-300 p-2 rounded-md">{{ old('deskripsi', $product->deskripsi) }}</textarea>
        </div>

        <div class="mb-4">
            <label for="gambar" class="block text-lg font-medium mb-2">Gambar Produk</label>
            <input type="file" id="gambar" name="gambar" class="w-full border-gray-300 p-2 rounded-md">
            @if($product->gambar)
                <div class="mt-2">
                    <img src="{{ asset('images/' . $product->gambar) }}" alt="{{ $product->nama }}" class="w-16 h-16 object-cover">
                </div>
            @endif
        </div>

        <h2 class="text-xl font-semibold mb-2">Varian Produk</h2>

        @foreach ($product->variants as $variant)
            <div class="border p-4 rounded mb-4">
                <input type="hidden" name="variants[{{ $loop->index }}][id]" value="{{ $variant->id }}">

                <div class="mb-2">
                    <label class="block font-medium">Ukuran</label>
                    <select name="variants[{{ $loop->index }}][ukuran]" class="w-full border-gray-300 p-2 rounded-md">
                        <option value="kecil" {{ $variant->ukuran == 'kecil' ? 'selected' : '' }}>Kecil</option>
                        <option value="sedang" {{ $variant->ukuran == 'sedang' ? 'selected' : '' }}>Sedang</option>
                        <option value="besar" {{ $variant->ukuran == 'besar' ? 'selected' : '' }}>Besar</option>
                    </select>
                </div>

                <div class="mb-2">
                    <label class="block font-medium">Harga</label>
                    <input type="number" name="variants[{{ $loop->index }}][harga]" value="{{ $variant->harga }}" class="w-full border-gray-300 p-2 rounded-md">
                </div>

                <div class="mb-2">
                    <label class="block font-medium">Stok</label>
                    <input type="number" name="variants[{{ $loop->index }}][stok]" value="{{ $variant->stok }}" class="w-full border-gray-300 p-2 rounded-md">
                </div>
            </div>
        @endforeach

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_best_seller" value="1" {{ old('is_best_seller') ? 'checked' : '' }} class="form-checkbox">
                <span class="ml-2 text-lg font-medium">Best Seller</span>
            </label>
        </div>

        <div class="mb-4">
            <label class="inline-flex items-center">
                <input type="checkbox" name="is_favorit" value="1" {{ old('is_favorit') ? 'checked' : '' }} class="form-checkbox">
                <span class="ml-2 text-lg font-medium">Favorit</span>
            </label>
        </div>

        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-md hover:bg-pink-600">Update Produk</button>
    </form>
</div>
@endsection
