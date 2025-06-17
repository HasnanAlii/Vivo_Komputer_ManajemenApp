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
                Nota Pembelian
            </div>
           <div class="text-right">
            <div>Nomor Faktur:</div>
            <div class="font-bold text-base">{{ $sales->first()->nomorFaktur ?? '-' }}</div>
            <div>Tanggal:</div>
            <div class="font-bold text-base">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
        </div>

        </div>


       <table class="w-full text-xs mb-4" style="border-collapse: collapse; width: 100%;">

            <thead>
                <tr style="border-bottom: 1px solid #000;">
                    <th align="left">Barang</th>
                    <th align="right">Jumlah</th>
                    <th align="right">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($sales as $sale)
                    <tr>
                        <td>{{ $sale->product->namaBarang }}</td>
                        <td align="right">{{ $sale->jumlah }}</td>
                        <td align="right">Rp {{ number_format($sale->jumlah * $sale->hargaTransaksi, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="text-right mt-2 pr-2">
            <div>Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></div>
            @if ($bayar == 0)
                <div>Pembayaran: <strong>Cicilan</strong></div>
            @else
                <div>Bayar: Rp {{ number_format($bayar, 0, ',', '.') }}</div>
                <div><strong>Kembalian: Rp {{ number_format($kembalian, 0, ',', '.') }}</strong></div>
            @endif
        </div>

        
         <div class="mt-2 border border-red-400 text-red-500 text-[9px] px-2 py-1 leading-tight max-w-xs">
            <p>- Barang yang sudah dibeli tidak dapat dikembalikan.</p>
            <p>- Simpan struk sebagai bukti transaksi.</p>
        </div>
    </div>

    <div class="no-print flex justify-center gap-4 mt-4">
        <button type="button" onclick="window.location='{{ route('sales.index') }}'"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow">
            🔙 Kembali
        </button>

        <button onclick="window.print()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
            🖨️ Cetak Nota
        </button>
    </div>
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
        width: 24.13cm; /* Lebar 9.5 inch */
        max-width: 24.13cm;
        padding: 0.5cm;
        font-size: 11px;
        line-height: 1.3;
        
    }

    .no-print {
        display: none !important;
    }

    @page {
        size: 9.5in 11in; /* ukuran kertas */
        margin: 0.5cm;
    }

    html, body {
        margin: 0;
        padding: 0;
    }
}

</style>
