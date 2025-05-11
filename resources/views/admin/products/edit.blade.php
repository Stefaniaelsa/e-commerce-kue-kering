@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="my-4">Edit Produk</h1>
    <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama Produk</label>
            <input type="text" id="nama" name="nama" class="form-control" value="{{ $product->nama }}" required>
        </div>
        <div class="form-group">
            <label for="deskripsi">Deskripsi Produk</label>
            <textarea id="deskripsi" name="deskripsi" class="form-control">{{ $product->deskripsi }}</textarea>
        </div>
        <div class="form-group">
            <label for="harga">Harga</label>
            <input type="number" id="harga" name="harga" class="form-control" value="{{ $product->harga }}" required>
        </div>
        <div class="form-group">
            <label for="stok">Stok</label>
            <input type="number" id="stok" name="stok" class="form-control" value="{{ $product->stok }}" required>
        </div>
        <div class="form-group">
            <label for="gambar">Gambar Produk</label>
            <input type="file" id="gambar" name="gambar" class="form-control">
            @if($product->gambar)
                <img src="{{ asset('storage/products/' . $product->gambar) }}" alt="gambar" class="mt-2" style="max-width: 150px;">
            @endif
        </div>
        <button type="submit" class="btn btn-primary mt-3">Update</button>
    </form>
</div>
@endsection
