@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Tambah Admin</h1>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.admins.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="nama" class="block mb-2 font-medium">Nama</label>
            <input type="text" name="nama" id="nama" class="w-full border p-2 rounded" value="{{ old('nama') }}" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-2 font-medium">Email</label>
            <input type="email" name="email" id="email" class="w-full border p-2 rounded" value="{{ old('email') }}" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-2 font-medium">Password</label>
            <input type="password" name="password" id="password" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block mb-2 font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border p-2 rounded" required>
        </div>
        <div class="mb-4">
            <label for="nomor_telepon" class="block mb-2 font-medium">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" id="nomor_telepon" class="w-full border p-2 rounded" value="{{ old('nomor_telepon') }}">
        </div>
        <div class="mb-4">
            <label for="alamat" class="block mb-2 font-medium">Alamat</label>
            <textarea name="alamat" id="alamat" class="w-full border p-2 rounded">{{ old('alamat') }}</textarea>
        </div>
        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Simpan</button>
    </form>
</div>
@endsection
