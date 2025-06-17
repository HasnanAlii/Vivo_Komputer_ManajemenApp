<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: center; }
        th { background-color: #f0f0f0; }
        .summary { margin-top: 30px; }
        .summary div { margin: 6px 0; }
    </style>
</head>
<body>
    <h2 align="center">Laporan Penjualan</h2>
  @if ($filter)
        <p>Filter Waktu: <strong>{{ ucfirst($filter) }}</strong></p>
    @endif
    @if ($employee)
        <p>Kasir: <strong>{{ $employee->nama }}</strong></p>
    @endif
    <p>Tanggal Cetak: {{ now()->format('d-m-Y ') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Faktur</th>
                <th>Produk</th>
                <th>Kasir</th>
                <th>Jumlah</th>
                <th>Total Harga</th>
                <th>Keuntungan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sales as $index => $sale)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $sale->nomorFaktur }}</td>
                    <td>{{ $sale->product->namaBarang ?? '-' }}</td>
                    <td>{{ $sale->employee->nama ?? '-' }}</td>
                    <td>{{ $sale->jumlah }}</td>
                    <td>Rp {{ number_format($sale->totalHarga, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($sale->keuntungan, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($sale->tanggal)->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="summary">
        <div><strong>Total Modal:</strong> Rp {{ number_format($totalModal, 0, ',', '.') }}</div>
        <div><strong>Total Pendapatan:</strong> Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</div>
        <div><strong>Total Keuntungan:</strong> Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</div>
    </div>
</body>
</html>
