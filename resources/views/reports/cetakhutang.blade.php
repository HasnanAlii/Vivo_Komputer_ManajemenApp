<x-app-layout>
    <div id="print-area" class="p-4 font-mono text-xs leading-tight" style="width: 21.6cm; max-width: 21.6cm;">

        <div class="flex justify-between items-start border-b border-black pb-2 mb-2">
            <div class="flex gap-4">
                <img src="/assets/images/struk.png" alt="Logo" style="width: 70px;">
                <div>
                    <div class="text-base font-bold">Vivo Komputer</div>
                    <div>Jl. Pasirgede Raya Bojongherang Cianjur</div>
                    <div>Telp: 0815-7202-4321</div>

                </div>
            </div>
            <div class="text-center text-base font-bold mb-2">
                Struk Pembayaran Hutang
            </div>
            <div class="text-right">
            @php
                $saleCicilan = $customer->sales->firstWhere('jenisPembayaran', 'cicilan');
            @endphp

            <div class="font-bold text-base">
                {{ $saleCicilan->nomorFaktur ?? '-' }}
            </div>

                <div>Nama:</div>
                <div class="font-bold text-base">{{ $customer->nama }}</div>
            </div>
        </div>

        <div class="font-bold mb-1">Barang yang di cicil : {{ $saleCicilan->product->namaBarang ?? '-' }}</div>
        <h4 class="font-bold mb-1">Riwayat Pembayaran:</h4>
        <table class="w-full text-xs mb-4" style="border-collapse: collapse;">
            <thead>
                <tr style="border-bottom: 1px solid #000;">
                    <th align="left">Tanggal</th>
                    <th align="right">Bayar</th>
                    <th align="right">Sisa</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($customer->pembayaran as $p)
                @if ($p->bayar > 0)
                <tr>
                    <td>{{ \Carbon\Carbon::parse($p->tanggalBayar)->format('d M Y') }}</td>
                    <td align="right">Rp {{ number_format($p->bayar, 0, ',', '.') }}</td>
                    <td align="right">Rp {{ number_format($p->sisaCicilan, 0, ',', '.') }}</td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="4" align="center">Belum ada pembayaran</td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="mb-4 text-right">
            <p><strong>Total Cicilan:</strong> Rp {{ number_format($customer->cicilan, 0, ',', '.') }}</p>
            <p><strong>Sisa Cicilan:</strong>
                Rp {{
                    number_format($customer->pembayaran->last()?->sisaCicilan ?? $customer->cicilan, 0, ',', '.')
                }}
            </p>
        </div>

        <div class="mt-2 border border-red-400 text-red-500 text-[9px] px-2 py-1 leading-tight max-w-xs">
            <p>- Simpan bukti pembayaran ini untuk keperluan arsip.</p>
            <p>- Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        </div>

    </div>
    {{-- <h4>Barang yang Dicicil:</h4>
    <ul>
        @foreach($customer->sales as $sale)
            @if($sale->keuntungan < 1)
                <li>{{ $sale->product->namaBarang }}</li>
            @endif
        @endforeach
    </ul> --}}

</x-app-layout>

<style>
    @media print {
        body * {
            visibility: hidden;
        }

        #print-area, #print-area * {
            visibility: visible;
        }

        #print-area {
            position: fixed;
            left: 0;
            top: 0;
            width: 24.13cm;
            max-width: 24.13cm;
            padding: 0.5cm;
            font-size: 11px;
            line-height: 1.3;
        }

        .no-print {
            display: none !important;
        }

        @page {
            size: 9.5in 11in;
            margin: 0.5cm;
        }

        html, body {
            margin: 0;
            padding: 0;
        }
    }
</style>

<script>
    window.onload = () => window.print();
</script>
