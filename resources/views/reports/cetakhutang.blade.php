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
                font-size: 12px;
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
                max-width: 100px !important;
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

    <div class="py-4 pl-4">
        <div id="print-area" class="text-sm font-mono" style="max-width: 28cm; width: 100%;">
            <div class="flex justify-between items-start border-b border-gray-900 pb-2 mb-2">
                <div class="flex gap-2">
                    <img src="/assets/images/struk.png" alt="Logo Vivo Komputer">
                    <div>
                        <strong class="text-lg">Vivo Komputer</strong><br>
                        Jl. Pasirgede Raya Bojongherang Cianjur<br>
                        Telp: 0815-7202-4321
                    </div>
                </div>
                <div class="text-right">
                    @php
                        $saleCicilan = $customer->sales->firstWhere('jenisPembayaran', 'cicilan');
                    @endphp
                     <strong class="text-lg">Struk Pembayaran Cicilan </strong>
                    <div>Nomor Faktur:</div>
                    <div class="font-bold text-base">{{ $saleCicilan->nomorFaktur ?? '-' }}</div>
                    <div>Nama:</div>
                    <div class="font-bold text-base">{{ $customer->nama }}</div>
                </div>
            </div>
                <p>Dicetak pada: {{ now()->format('d M Y H:i') }}</p>

           <div class="font-bold mb-1">Barang yang dicicil:</div>
                <ul class="list-disc ml-5 mb-2 text-sm leading-tight">
                    @php
                        $barangCicilan = $customer->sales->where('jenisPembayaran', 'cicilan');
                    @endphp

                    @forelse ($barangCicilan as $sale)
                        <li>
                           {{ $sale->product->namaBarang ?? '-' }}
                        </li>
                    @empty
                        <li>Tidak ada barang yang dicicil</li>
                    @endforelse
                </ul>


            <h4 class="font-bold mb-1">Riwayat Pembayaran:</h4>
            <table class="w-full mt-2 text-xs">
                <thead>
                    <tr class="bg-gray-100">
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
                            <td colspan="3" align="center">Belum ada pembayaran</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="text-right mt-2">
                <p><strong>Total Cicilan:</strong> Rp {{ number_format($customer->cicilan, 0, ',', '.') }}</p>
                <p><strong>Sisa Cicilan:</strong>
                    Rp {{
                        number_format($customer->pembayaran->last()?->sisaCicilan ?? $customer->cicilan, 0, ',', '.')
                    }}
                </p>
            </div>
{{-- 
          <div class="mt-4 border border-black text-black text-[9px]  px-3 py-2 leading-tight max-w-md print:text-[9px]">
                {{-- <p>- Simpan bukti pembayaran ini untuk keperluan arsip.</p> --}}
                {{-- <p>- Dicetak pada: {{ now()->format('d M Y H:i') }}</p>
        </div>  --}}
            
        </div>

        <!-- Tombol Aksi -->
        <div class="text-center mt-6 no-print gap-4">
       
            <button type="button" onclick="window.location='{{ route('reports.customers') }}'"
           class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow transition">
           🔙
       </button>
            <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 ml-4 text-white font-semibold px-6 py-2 rounded shadow">
                🖨️ Cetak Struk
            </button>
        </div>
    </div>
</x-app-layout>
