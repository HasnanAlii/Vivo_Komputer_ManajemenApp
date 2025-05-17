<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Pembelian</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Laporan Pembelian</h2>
    <p>Filter: {{ ucfirst($filter) ?: 'Semua' }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Penjual</th>
                <th>Nama Barang</th>
                <th>Jumlah</th>
                <th>Harga Beli</th>
                <th>Harga Jual</th>
                <th>Keuntungan</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($purchasings as $index => $p)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $p->customer->nama ?? '-' }}</td>
                    <td>{{ $p->product->namaBarang ?? '-' }}</td>
                    <td>{{ $p->jumlah }}</td>
                    <td>Rp {{ number_format($p->hargaBeli, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($p->hargaJual, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($p->keuntungan, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align:center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <br><br>
    <table style="width: 50%;">
        <tr>
            <td><strong>Total Modal</strong></td>
            <td>Rp {{ number_format($totalModal, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Keuntungan</strong></td>
            <td>Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</td>
        </tr>
        <tr>
            <td><strong>Total Pendapatan</strong></td>
            <td>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</td>
        </tr>
    </table>
</body>
</html>
