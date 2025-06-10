@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Tambah Produk</h1>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div class="mb-4">
            <label for="nama" class="block text-lg font-medium mb-2">Nama Produk</label>
            <input type="text" id="nama" name="nama" value="{{ old('nama') }}" class="w-full border-gray-300 p-2 rounded-md" required>
        </div>

        <div class="mb-4">
            <label for="deskripsi" class="block text-lg font-medium mb-2">Deskripsi Produk</label>
            <textarea id="deskripsi" name="deskripsi" class="w-full border-gray-300 p-2 rounded-md">{{ old('deskripsi') }}</textarea>
        </div>

        <div class="mb-4">
            <label for="gambar" class="block text-lg font-medium mb-2">Gambar Produk</label>
            <input type="file" id="gambar" name="gambar" class="w-full border-gray-300 p-2 rounded-md">
        </div>

        <!-- Checkbox: apakah memiliki varian -->
        <div class="mb-4">
            <label for="has_variants" class="block text-lg font-medium mb-2">Produk Memiliki Varian?</label>
            <input type="checkbox" id="has_variants" name="has_variants" value="1" {{ old('has_variants') ? 'checked' : '' }}>
            <span class="text-sm">Centang jika produk memiliki varian ukuran</span>
        </div>

        <!-- Form varian -->
        <div id="variant_fields" style="display: none;">
            <h2 class="text-xl font-semibold mt-6 mb-4">Tambah Varian Produk</h2>

            @php
                $sizes = ['kecil', 'sedang', 'besar'];
            @endphp

            @foreach($sizes as $index => $size)
                <div class="mb-4 border p-4 rounded-md bg-gray-50">
                    <label class="flex items-center space-x-2 mb-2">
                        <input type="checkbox" name="variants[{{ $index }}][enabled]" value="1" class="variant-toggle" data-index="{{ $index }}" {{ old("variants.$index.enabled") ? 'checked' : '' }}>
                        <span class="font-medium text-lg">Ukuran {{ ucfirst($size) }}</span>
                    </label>
                    <input type="hidden" name="variants[{{ $index }}][ukuran]" value="{{ $size }}">

                    <div class="variant-inputs" id="variant-inputs-{{ $index }}" style="display: none;">
                        <label class="block text-sm font-medium mb-1">Harga Ukuran {{ ucfirst($size) }}</label>
                        <input type="number" name="variants[{{ $index }}][harga]" value="{{ old("variants.$index.harga") }}" class="w-full border-gray-300 p-2 rounded-md mb-2" placeholder="Harga">

                        <label class="block text-sm font-medium mb-1">Stok Ukuran {{ ucfirst($size) }}</label>
                        <input type="number" name="variants[{{ $index }}][stok]" value="{{ old("variants.$index.stok") }}" class="w-full border-gray-300 p-2 rounded-md" placeholder="Stok">
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Jika tidak memiliki varian -->
        <div id="no_variant_fields">
            <div class="mb-4">
                <label for="harga" class="block text-lg font-medium mb-2">Harga</label>
                <input type="number" id="harga" name="harga" value="{{ old('harga')}}" class="w-full border-gray-300 p-2 rounded-md">
            </div>

            <div class="mb-4">
                <label for="stok" class="block text-lg font-medium mb-2">Stok</label>
                <input type="number" id="stok" name="stok" value="{{ old('stok')}}"  class="w-full border-gray-300 p-2 rounded-md">
            </div>
        </div>

        <!-- Checkbox Best Seller dan Favorit -->
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
        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded-md hover:bg-pink-600">Simpan Produk</button>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const hasVariantsCheckbox = document.getElementById('has_variants');
        const variantFields = document.getElementById('variant_fields');
        const noVariantFields = document.getElementById('no_variant_fields');
        const hargaInput = document.getElementById('harga');
        const stokInput = document.getElementById('stok');

        function toggleVariantFields() {
            if (hasVariantsCheckbox.checked) {
                variantFields.style.display = 'block';
                noVariantFields.style.display = 'none';
                hargaInput.removeAttribute('required');
                stokInput.removeAttribute('required');
            } else {
                variantFields.style.display = 'none';
                noVariantFields.style.display = 'block';
                hargaInput.setAttribute('required', 'required');
                stokInput.setAttribute('required', 'required');
            }
        }

        toggleVariantFields();
        hasVariantsCheckbox.addEventListener('change', toggleVariantFields);

        const variantToggles = document.querySelectorAll('.variant-toggle');
        variantToggles.forEach(toggle => {
            toggle.addEventListener('change', function () {
                const index = this.dataset.index;
                const inputs = document.getElementById(`variant-inputs-${index}`);
                inputs.style.display = this.checked ? 'block' : 'none';
            });

            // On load
            if (toggle.checked) {
                document.getElementById(`variant-inputs-${toggle.dataset.index}`).style.display = 'block';
            }
        });
    });
</script>
@endsection
