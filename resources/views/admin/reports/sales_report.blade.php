<!DOCTYPE html>
<html>
<head>
    <title>Laporan Penjualan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f5f5f5;
        }
        .summary {
            margin-top: 30px;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Laporan Penjualan</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d/m/Y') }} - {{ \Carbon\Carbon::parse($endDate)->format('d/m/Y') }}</p>
    </div>

    <div class="summary">
        <h3>Ringkasan</h3>
        <table>
            <tr>
                <td><strong>Total Pesanan:</strong></td>
                <td>{{ $totalOrders }}</td>
            </tr>
            <tr>
                <td><strong>Total Pendapatan:</strong></td>
                <td>Rp {{ number_format($totalRevenue, 0, ',', '.') }}</td>
            </tr>
        </table>
    </div>

    <h3>Detail Pesanan</h3>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Pelanggan</th>
                <th>Produk</th>
                <th>Status</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ \Carbon\Carbon::parse($order->tanggal_pesanan)->format('d/m/Y') }}</td>
                <td>{{ $order->user->nama }}</td>
                <td>
                    @foreach($order->products as $product)
                        {{ $product->nama }}<br>
                    @endforeach
                </td>
                <td>{{ ucfirst($order->status) }}</td>
                <td>Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ \Carbon\Carbon::now()->format('d/m/Y H:i:s') }}</p>
    </div>
</body>
</html>
