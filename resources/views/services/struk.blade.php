<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Struk Service') }}
        </h2>
    </x-slot>

    <style>
        @media print {
            /* Sembunyikan semua kecuali #print-area */
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
                width: 100%;
            }
        }
    </style>

    <div class="py-6">
        <div class="max-w-3xl mx-auto bg-white p-8 shadow-lg rounded-lg border" id="print-area">
            <!-- Semua isi struk kamu di sini, tanpa tombol & header yang ingin disembunyikan -->
            
            <div class="flex items-center justify-between border-b pb-4 mb-4">
                <div class="flex items-center space-x-4">
                    <img src="/assets/images/struk.png" alt="Vivo Komputer Logo" class="w-24 h-auto">
                    <div>
                        <h1 class="text-2xl font-bold text-gray-800">Vivo Komputer</h1>
                        <p class="text-sm text-gray-600">Jl. Pasirgede Raya Bojongherang Cianjur </p>
                        <p class="text-sm text-gray-600 ">Telp: 0812-3456-7890</p>
                    </div>
                </div>
                <div class="text-right ">
                    <p class="text-sm text-gray-600">Nomor Faktur:</p>
                    <p class="text-lg font-bold text-gray-900">{{ $service->nomorFaktur }}</p>
                </div>
            </div>

            <div class="flex justify-between gap-8 mb-6">
                <div class="w-1/2">
                    <h3 class="font-semibold text-gray-700 mb-1">Informasi Service</h3>
                    <p><strong>Perangkat:</strong> {{ $service->jenisPerangkat }}</p>
                    <p><strong>Kerusakan:</strong> {{ $service->kerusakan ?? '-' }}</p>
                    <p><strong>Kelengkapan:</strong> {{ $service->kelengkapan?? '-' }}</p>
                    <p><strong>Kondisi awal Barang :</strong> {{ $service->kondisi ?? '-' }}</p>
                    <p><strong>Status:</strong>   @if ($service->status)
                        <span class="">Selesai</span>
                        @else
                        <span class="">Proses</span>
                        @endif</p>
                        <p><strong>Catatan Teknisi:</strong> {{ $service->keterangan ?? '-' }}</p>
                </div>
                <div class="w-1/2">
                    <h3 class="font-semibold text-gray-700 mb-1">Customer</h3>
                    <p><strong>Nama:</strong> {{ $service->customer->nama }}</p>
                    <p><strong>No Telp:</strong> {{ $service->customer->noTelp }}</p>
                    <p><strong>Alamat:</strong> {{ $service->customer->alamat }}</p>
                    <p><strong>Tanggal Masuk:</strong> {{ $service->created_at->format('d M Y') }}</p>
                </div>
            </div>

            <div class="mb-6">
                <h3 class="font-semibold text-gray-700 mb-2">Rincian Biaya</h3>
                <table class="w-full text-sm text-left text-gray-700 border border-gray-300">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="p-2 border">Item</th>
                            <th class="p-2 border text-right">Harga</th>
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
                                <td class="p-2 border"> sparepart{{ $product->namaBarang }}</td>
                                <td class="p-2 border text-right">
                                    {{ $product->hargaBeli > 0 ? 'Rp ' . number_format($product->hargaBeli, 0, ',', '.') : '-' }}
                                </td>
                            </tr>
                        @endforeach
                        <tr>
                            <td class="p-2 border font-semibold">Biaya Jasa</td>
                            <td class="p-2 border text-right">
                                {{ $service->biayaJasa > 0 ? 'Rp ' . number_format($service->biayaJasa, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                        <tr class="bg-gray-100">
                            <td class="p-2 border font-bold">Total Harga</td>
                            <td class="p-2 border text-right font-bold">
                                {{ $service->totalHarga > 0 ? 'Rp ' . number_format($service->totalHarga, 0, ',', '.') : '-' }}
                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>
        </div>

        <!-- Tombol hanya di luar #print-area agar tidak ikut tercetak -->
        <div class="text-center mt-8 " >
            <button type="button" onclick="window.location='{{ route('service.index') }}'"
                    class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                🔙
            </button>
            <button onclick="window.print()" class="bg-blue-600 hover:bg-blue-700 ml-4 text-white font-semibold px-6 py-2 rounded shadow">
                🖨️ Cetak Struk
            </button>
        </div>
    </div>
</x-app-layout>
