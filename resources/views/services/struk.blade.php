<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Struk Service') }}
        </h2>
    </x-slot>

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
                width: 21.6cm; /* approx 8.5 inch width */
                max-width: 21.6cm;
                padding: 0.5cm;
                font-size: 11px;
                line-height: 1.3;
            }
            table, th, td {
                border: 1px solid #999;
                border-collapse: collapse;
            }
            th, td {
                padding: 4px;
            }
            img {
                max-width: 80px !important;
            }
        }
    </style>

    <div class="py-4">
        <div id="print-area" class="border border-gray-300 p-4 text-sm font-mono">
            <div class="flex justify-between border-b pb-2 mb-2">
                <div class="flex items-start gap-4">
                    <img src="/assets/images/struk.png" alt="Vivo Komputer Logo">
                    <div>
                        <strong class="text-lg">Vivo Komputer</strong><br>
                        Jl. Pasirgede Raya Bojongherang Cianjur<br>
                        Telp: 0815-7202-4321

                    </div>
                </div>
                <div class="text-right">
                <div>Nomor Faktur:</div>
                <div class="font-bold text-base">{{ $service->first()->nomorFaktur ?? '-' }}</div>
                <div>Tanggal:</div>
                <div class="font-bold text-base">{{ \Carbon\Carbon::now()->format('d M Y') }}</div>
            </div>

            </div>

            <div class="flex justify-between gap-8 mb-4">
                <div class="w-1/2">
                    <strong>Informasi Service</strong><br>
                    <div>Perangkat: {{ $service->jenisPerangkat }}</div>
                    <div>Kerusakan: {{ $service->kerusakan ?? '-' }}</div>
                    <div>Kelengkapan: {{ $service->kelengkapan ?? '-' }}</div>
                    <div>Kondisi Awal: {{ $service->kondisi ?? '-' }}</div>
                    <div>Status:
                        @if ($service->status)
                            Selesai
                        @else
                            Proses
                        @endif
                    </div>
                    <div>Catatan Teknisi: {{ $service->keterangan ?? '-' }}</div>
                </div>
                <div class="w-1/2">
                    <strong>Customer</strong><br>
                    <div>Nama: {{ $service->customer->nama }}</div>
                    <div>No Telp: {{ $service->customer->noTelp }}</div>
                    <div>Alamat: {{ $service->customer->alamat }}</div>
                    <div>Tanggal Masuk: {{ $service->created_at->format('d M Y') }}</div>
                </div>
            </div>

            <div>
                <strong>Rincian Biaya</strong>
                <table class="w-full mt-2 text-xs">
                    <thead>
                        <tr class="bg-gray-100">
                            <th>Item</th>
                            <th class="text-right">Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $produkList = [];
                            if ($service->idProduct) {
                                $produkID = explode(',', $service->idProduct);
                                $products = \App\Models\Product::whereIn('idProduct', $produkID)->get();
                            }
                        @endphp
                        @foreach ($products as $product)
                            <tr>
                                <td>Sparepart: {{ $product->namaBarang }}</td>
                                <td class="text-right">
                                    {{ $product->hargaJual > 0 ? 'Rp ' . number_format($product->hargaJual, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td><strong>Biaya Jasa</strong></td>
                            <td class="text-right">
                                {{ $service->biayaJasa > 0 ? 'Rp ' . number_format($service->biayaJasa, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td><strong>Total Harga</strong></td>
                            <td class="text-right font-bold">
                                {{ $service->totalHarga > 0 ? 'Rp ' . number_format($service->totalHarga, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

         <div class="mt-2 border border-red-400 text-red-500 text-[8px] px-2 py-1 leading-tight max-w-xs">
    <p>- Barang yang sudah dibeli tidak dapat ditukar/dikembalikan.</p>
    <p>- Garansi sesuai tanggal yang tertera.</p>
    <p>- Garansi batal jika segel rusak.</p>
    <p>- Service lebih dari 1 bulan tidak diambil kami tidak bertanggung jawab jika barang tersebut rusak.</p>
</div>

        </div>

        <!-- Tombol di luar area cetak -->
        <div class="text-center mt-6">
            <button onclick="window.location='{{ route('service.index') }}'"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow">
                🔙 Kembali
            </button>
            <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 ml-4 text-white font-semibold px-6 py-2 rounded shadow">
                🖨️ Cetak Struk
            </button>
        </div>
    </div>
</x-app-layout>
