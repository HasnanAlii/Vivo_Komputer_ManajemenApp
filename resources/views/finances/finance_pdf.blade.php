<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Keuangan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 6px; text-align: left; }
        th { background-color: #eef; }
        .summary { margin-top: 20px; }
    </style>
</head>
<body>

<h2 style="text-align:center;"> Laporan Keuangan</h2>
<p>Filter: {{ ucfirst($filter ?? 'Semua') }}</p>
<p>Tanggal Cetak: {{ now()->format('d-m-Y ') }}</p>

<table>
    <thead>
        <tr>
            <th>No</th>
            <th>Aliran Dana</th>
            <th>Modal</th>
            <th>Keuntungan</th>
            <th>Total</th>
            <th>Keterangan</th>
            <th>No Faktur</th>
            <th>Tanggal</th>
        </tr>
    </thead>
    <tbody>
        @forelse($finances as $i => $item)
        <tr>
            <td>{{ $i + 1 }}</td>
            <td>Rp {{ number_format($item->dana, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->modal, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->keuntungan, 0, ',', '.') }}</td>
            <td>Rp {{ number_format($item->totalDana, 0, ',', '.') }}</td>
            <td>{{ $item->keterangan }}</td>
            <td>
                {{ $item->purchasings->nomorFaktur ?? $item->sales->nomorFaktur ?? $item->services->nomorFaktur ?? '-' }}
            </td>
            <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
        </tr>
        @empty
        <tr><td colspan="8" style="text-align:center;">Tidak ada data</td></tr>
        @endforelse
    </tbody>
</table>

<div class="summary">
    <p><strong>Total Modal:</strong> Rp {{ number_format($totalModal, 0, ',', '.') }}</p>
    <p><strong>Total Keuntungan:</strong> Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</p>
    <p><strong>Total Dana:</strong> Rp {{ number_format($totalDana, 0, ',', '.') }}</p>
</div>

</body>
</html>
