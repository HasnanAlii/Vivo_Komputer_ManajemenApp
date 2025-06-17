<x-app-layout>
    <style>
        @media print {
            body * {
                visibility: hidden;
            }
            #print-area, #print-area * {
                visibility: visible;
            }
            #print-area {
                position: absolute;
                left: 0;
                top: 0;
                width: 28cm;
                max-width: 28cm;
                font-size: 14px;
                line-height: 1.3;
                padding: 0.5cm;
            }
            table, th, td {
                border: 1px solid #999;
                border-collapse: collapse;
            }
            th, td {
                padding: 4px;
            }
            img {
                max-width: 110px !important;
            }
            .no-print {
                display: none !important;
            }
            @page {
                size: auto;
                margin: 0.5cm;
            }
        }
    </style>

    <div class="py-4">
        <div id="print-area" class="text-sm font-mono" style="max-width: 28cm; width: 100%;">
            <div class="flex justify-between items-start border-b border-gray-900 pb-2 mb-2">
                <div class="flex gap-4">
                    <img src="/assets/images/struk.png" alt="Logo" style="width: 70px;">
                    <div>
                        <strong class="text-base font-bold">Vivo Komputer</strong>
                        <div>Jl. Pasirgede Raya Bojongherang Cianjur</div>
                        <div>Telp: 0815-7202-4321</div>
                    </div>
                </div>
                <div class="text-right">
                    <strong class="text-lg">Struk Pembelian Barang</strong>
                    <div>Nomor Faktur:</div>
                    <div class="font-bold text-base">{{ $sales->first()->nomorFaktur ?? '-' }}</div>
                    <div>Tanggal:</div>
                    <div class="font-bold text-base">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
                </div>
            </div>

            <table class="w-full text-xs mb-4">
                <thead>
                    <tr class="border-b border-black">
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

             <div class="mt-4 border border-black text-black text-[9px]  px-3 py-2 leading-tight max-w-md print:text-[9px]">
            <p>• Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
            <p>• Garansi sesuai tanggal yang tertera.</p>
            <p>• Garansi batal jika segel rusak.</p>
            <p>• Simpan struk sebagai bukti transaksi.</p>
            {{-- <p>• Service lebih dari 1 bulan tidak diambil, kami tidak bertanggung jawab jika barang tersebut rusak.</p> --}}
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
    </div>
</x-app-layout>
