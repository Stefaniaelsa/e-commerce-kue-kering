@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Edit User</h1>

    @if ($errors->any())
    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-4">
            <label for="nama" class="block mb-2 font-medium">Nama</label>
            <input type="text" name="nama" id="nama" class="w-full border p-2 rounded" value="{{ old('nama', $user->nama) }}" required>
        </div>
        <div class="mb-4">
            <label for="email" class="block mb-2 font-medium">Email</label>
            <input type="email" name="email" id="email" class="w-full border p-2 rounded" value="{{ old('email', $user->email) }}" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-2 font-medium">Password (biarkan kosong jika tidak ingin diubah)</label>
            <input type="password" name="password" id="password" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label for="password_confirmation" class="block mb-2 font-medium">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border p-2 rounded">
        </div>
        <div class="mb-4">
            <label for="nomor_telepon" class="block mb-2 font-medium">Nomor Telepon</label>
            <input type="text" name="nomor_telepon" id="nomor_telepon" class="w-full border p-2 rounded" value="{{ old('nomor_telepon', $user->nomor_telepon) }}">
        </div>
        <div class="mb-4">
            <label for="alamat" class="block mb-2 font-medium">Alamat</label>
            <textarea name="alamat" id="alamat" class="w-full border p-2 rounded">{{ old('alamat', $user->alamat) }}</textarea>
        </div>
        <div class="mb-4">
            <label for="role" class="block mb-2 font-medium">Role</label>
            <select name="role" id="role" class="w-full border p-2 rounded">
                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">Update</button>
    </form>
</div>
@endsection
