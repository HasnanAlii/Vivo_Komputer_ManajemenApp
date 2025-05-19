<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Perbaikan Barang Vivo Komputer</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eee; }
        .summary { margin-top: 20px; }
    </style>
</head>
<body>

    <h2 style="text-align: center;">Laporan Data Perbaikan Barang</h2>
    <p>Filter: {{ ucfirst($filter ?? 'Semua') }}</p>
    <p>Tanggal Cetak: {{ now()->format('d-m-Y ') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Barang</th>
                <th>Kerusakan</th>
                <th>Sparepart</th>
                <th>Biaya Service</th>
                <th>Tgl Masuk</th>
                <th>Tgl Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($services as $index => $service)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $service->customer->nama }}</td>
                    <td>{{ $service->jenisPerangkat }}</td>
                    <td>{{ $service->kerusakan ?? '-' }}</td>
                    <td>
                        @if($service->products->isNotEmpty())
                            {{ $service->products->pluck('namaBarang')->join(', ') }}
                        @else
                            -
                        @endif
                    </td>
                    <td>Rp {{ number_format($service->totalHarga, 0, ',', '.') }}</td>
                    <td>{{ \Carbon\Carbon::parse($service->tglMasuk)->format('d-m-Y') }}</td>
                    <td>{{ $service->tglSelesai ? \Carbon\Carbon::parse($service->tglSelesai)->format('d-m-Y') : '-' }}</td>
                    <td>{{ $service->status ? 'Selesai' : 'Proses' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">Tidak ada data</td>
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
