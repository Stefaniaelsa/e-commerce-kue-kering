@extends('layouts.app')

@section('content')
    <div class="p-8 max-w-md mx-auto bg-white rounded shadow">
        <h1 class="text-3xl font-bold mb-6 text-center">Detail User</h1>

        <table class="w-full table-auto border-collapse border border-gray-300">
            <tbody>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left w-1/3">Nama</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $user->nama }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Email</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $user->email }}</td>
                </tr>
                <tr class="bg-gray-100">
                    <th class="border border-gray-300 px-4 py-2 text-left">Nomor Telepon</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $user->nomor_telepon }}</td>
                </tr>
                <tr>
                    <th class="border border-gray-300 px-4 py-2 text-left">Alamat</th>
                    <td class="border border-gray-300 px-4 py-2">{{ $user->alamat }}</td>
                </tr>
            </tbody>
        </table>

        <a href="{{ route('admin.users.index') }}" class="mt-6 inline-block text-blue-600 hover:underline">
            &larr; Kembali ke daftar user
        </a>
    </div>
@endsection
