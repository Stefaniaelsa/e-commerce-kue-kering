<form action="{{ route('order.store') }}" method="POST">
    @csrf

    @if ($items->isEmpty())
        <p>Keranjang kamu kosong, silakan tambah produk dulu.</p>
    @else
        @foreach ($items as $item)
            <input type="hidden" name="items[]" value="{{ $item->id }}">
            <p>{{ $item->produk->nama }} - Qty: {{ $item->jumlah }}</p>
        @endforeach

        <!-- Form lain seperti nama, alamat, metode pembayaran -->
        <button type="submit">Lanjut Pembayaran</button>
    @endif
</form>
