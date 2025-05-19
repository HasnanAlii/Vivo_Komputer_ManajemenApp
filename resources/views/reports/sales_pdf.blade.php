<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan Vivo Komputer</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; }
        th { background-color: #f0f0f0; text-align: center; }
        td { vertical-align: top; }
        .summary-table td { border: none; padding: 5px; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Laporan Penjualan</h2>
    <p>Filter: {{ ucfirst($filter) ?: 'Semua' }}</p>
    <p>Tanggal Cetak: {{ now()->format('d-m-Y ') }}</p>


    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nomor Faktur</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Jumlah</th>
                <th>Keuntungan</th>
                <th>Total Harga</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($sales as $index => $item)
                <tr>
                    <td style="text-align: center;">{{ $index + 1 }}</td>
                    <td style="text-align: center;">{{ $item->nomorFaktur }}</td>
                    <td>{{ $item->product->namaBarang ?? '-' }}</td>
                    <td>{{ $item->product->category->namaKategori ?? '-' }}</td>
                    <td style="text-align: center;">{{ $item->jumlah }}</td>
                    <td>Rp {{ number_format($item->keuntungan, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($item->totalHarga, 0, ',', '.') }}</td>
                    <td style="text-align: center;">{{ Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center;">Tidak ada data.</td>
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
