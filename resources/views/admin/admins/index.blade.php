@extends('layouts.app')

@section('content')
<div class="p-8">
    <h1 class="text-3xl font-bold mb-6">Daftar Admin</h1>

    <a href="{{ route('admin.admins.create') }}" class="inline-block bg-pink-500 hover:bg-pink-600 text-white font-semibold px-4 py-2 rounded mb-6">
        + Tambah Admin
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
                    <th class="py-3 px-4 border-b text-left">Nama</th>
                    <th class="py-3 px-4 border-b text-left">Email</th>
                    <th class="py-3 px-4 border-b text-left">Nomor Telepon</th>
                    <th class="py-3 px-4 border-b text-left">Alamat</th>
                    <th class="py-3 px-4 border-b text-left">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                    <tr class="hover:bg-gray-50">
                        <td class="py-2 px-4 border-b">{{ $admins->firstItem() + $loop->index }}</td>
                        <td class="py-2 px-4 border-b">{{ $admin->nama }}</td>
                        <td class="py-2 px-4 border-b">{{ $admin->email }}</td>
                        <td class="py-2 px-4 border-b">{{ $admin->nomor_telepon ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">{{ $admin->alamat ?? '-' }}</td>
                        <td class="py-2 px-4 border-b">
                            <div class="flex space-x-2">
                                <a href="{{ route('admin.admins.edit', $admin->id) }}"
                                   class="bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded">
                                    Edit
                                </a>
                                <form action="{{ route('admin.admins.destroy', $admin->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus admin ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-4 px-4 text-center text-gray-500">Belum ada admin.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $admins->links() }}
    </div>
</div>
@endsection
