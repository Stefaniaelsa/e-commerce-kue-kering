@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Tambah Produk</h1>
    @if (session('errors'))
        {{ session('errors') }}
    @endif
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="nama" class="block text-lg font-medium mb-2">Nama Produk</label>
            <input type="text" id="nama" name="nama" class="w-full border-gray-300 p-2 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-lg font-medium mb-2">Deskripsi Produk</label>
            <textarea id="deskripsi" name="deskripsi" class="w-full border-gray-300 p-2 rounded-md"></textarea>
        </div>

        <div class="mb-4">
            <label for="harga" class="block text-lg font-medium mb-2">Harga</label>
            <input type="number" id="harga" name="harga" class="w-full border-gray-300 p-2 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="stok" class="block text-lg font-medium mb-2">Stok</label>
            <input type="number" id="stok" name="stok" class="w-full border-gray-300 p-2 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="gambar" class="block text-lg font-medium mb-2">Gambar Produk</label>
            <input type="file" id="gambar" name="gambar" class="w-full border-gray-300 p-2 rounded-md">
        </div>

        <div class="mb-4">
            <label class="block text-lg font-medium mb-2">Produk Memiliki Varian?</label>
            <input type="hidden" name="has_variants" id="has_variants_hidden" value="0">
            <input type="checkbox" id="has_variants_checkbox" class="mr-2"> Ya
        </div>

        <div id="variant-section" class="hidden">
            <div class="mb-4">
                <label for="ukuran" class="block text-lg font-medium mb-2">Ukuran</label>
                <select id="ukuran" name="ukuran" class="w-full border-gray-300 p-2 rounded-md">
                    <option value="kecil">Kecil</option>
                    <option value="sedang">Sedang</option>
                    <option value="besar">Besar</option>
                </select>
            </div>

            <div class="mb-4">
                <label for="variant_harga" class="block text-lg font-medium mb-2">Harga Varian</label>
                <input type="number" id="variant_harga" name="variant_harga" class="w-full border-gray-300 p-2 rounded-md">
            </div>

            <div class="mb-4">
                <label for="variant_stok" class="block text-lg font-medium mb-2">Stok Varian</label>
                <input type="number" id="variant_stok" name="variant_stok" class="w-full border-gray-300 p-2 rounded-md">
            </div>
        </div>

        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-md hover:bg-pink-600">Simpan Produk</button>
    </form>
</div>

<script>
    document.getElementById('has_variants_checkbox').addEventListener('change', function () {
        const variantSection = document.getElementById('variant-section');
        const hiddenInput = document.getElementById('has_variants_hidden');

        if (this.checked) {
            hiddenInput.value = '1';
            variantSection.classList.remove('hidden');
        } else {
            hiddenInput.value = '0';
            variantSection.classList.add('hidden');
        }
    });
</script>
@endsection
