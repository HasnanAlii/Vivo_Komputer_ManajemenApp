<!DOCTYPE html>
<html>
<head>
    <title>Laporan Service</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ccc; padding: 4px; text-align: left; }
        th { background-color: #eee; }
    </style>
</head>
<body>
    <h2 align="center">Laporan Service</h2>
    @if ($filter)
        <p>Filter Waktu: <strong>{{ ucfirst($filter) }}</strong></p>
    @endif
    @if ($employee)
        <p>Teknisi: <strong>{{ $employee->nama }}</strong></p>
    @endif
    <p>Tanggal Cetak: {{ now()->format('d-m-Y ') }}</p>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pelanggan</th>
                <th>Barang</th>
                <th>Kerusakan</th>
                <th>Sparepart Digunakan</th>
                <th>Biaya Service</th>
                <th>Teknisi</th>
                <th>Jasa yang digunakan</th>
                <th>Tanggal Masuk</th>
                <th>Tanggal Selesai</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($services as $i => $service)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $service->customer->nama }}</td>
                    <td>{{ $service->jenisPerangkat }}</td>
                    <td>{{ $service->kerusakan ?? '-' }}</td>
                    <td>
                        {{ $service->products->pluck('namaBarang')->join(', ') ?: '-' }}
                    </td>
                    <td>Rp {{ number_format($service->totalHarga, 0, ',', '.') }}</td>
                    <td>{{ $service->employee->nama ?? '-' }}</td>
                    <td>{{ $service->jasa }}</td>
                    <td>{{ $service->tglMasuk }}</td>
                    <td>{{ $service->tglSelesai ?? '-' }}</td>
                    <td>{{ $service->status ? 'Selesai' : 'Proses' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <h4>Ringkasan:</h4>
    <ul>
        <li>Total Modal: Rp {{ number_format($totalModal, 0, ',', '.') }}</li>
        <li>Total Keuntungan: Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</li>
        <li>Total Pendapatan: Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</li>
    </ul>
</body>
</html>
