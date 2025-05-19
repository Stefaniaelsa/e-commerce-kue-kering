@extends('layouts.app')

@section('content')
  <h2 class="text-xl font-bold mb-4">Konfirmasi Pesanan</h2>

  @foreach($items as $item)
    <div class="mb-4 border-b pb-2">
      <p>{{ $item->produk->nama }} - Jumlah: {{ $item->jumlah }}</p>
      <p>Subtotal: Rp{{ number_format($item->harga, 0, ',', '.') }}</p>
    </div>
  @endforeach

  <form method="POST" action="{{ route('order.store') }}">
    @csrf
    @foreach($items as $item)
      <input type="hidden" name="items[]" value="{{ $item->id }}">
    @endforeach
    <button type="submit" class="bg-pink-500 text-white px-4 py-2 rounded hover:bg-pink-600">
      Konfirmasi Pesanan
    </button>
  </form>
@endsection
