<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <button type="button" onclick="window.location='{{ route('reports.index') }}'"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow transition">
                🔙 
            </button>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Daftar Hutang Pelanggan
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6 overflow-x-auto">
                @php $no = 1; @endphp
                <table class="min-w-full table-auto border border-gray-200 text-gray-800">
                    <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                        <tr>
                            <th class="p-3 border">No</th>
                            <th class="p-3 border">Nama Pelanggan</th>
                            <th class="p-3 border">Barang yang Dicicil</th>
                            <th class="p-3 border text-center">Total Cicilan</th>
                            <th class="p-3 border text-center">Sisa Cicilan</th>
                            <th class="p-3 border text-center">Pembayaran Terakhir</th>
                            <th class="p-3 border text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="text-sm">
                        @forelse ($customers as $customer)
                            @php
                                $lastPembayaran = $customer->pembayaran->last();
                                $sisa = $lastPembayaran?->sisaCicilan ?? $customer->cicilan;
                                $bayar = $lastPembayaran?->bayar ?? 0;
                            @endphp
                       
                         @if($customer->cicilan > 0)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border text-center">{{ $no++ }}</td>
                                    <td class="p-3 border">{{ $customer->nama }}</td>
                                    <td class="p-3 border">
                                        <ul class="list-disc list-inside">
                                            @foreach ($customer->sales as $sale)
                                                @if($sale->keuntungan < 1)
                                                    <li>{{ $sale->product->namaBarang }}</li>
                                                @endif
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="p-3 border text-center text-red-700 font-bold">
                                        Rp {{ number_format($customer->cicilan, 0, ',', '.') }}
                                    </td>
                                    <td class="p-3 border text-center text-orange-600 font-semibold">
                                        Rp {{ number_format($sisa, 0, ',', '.') }}
                                    </td>
                                   <td class="p-3 border text-sm text-green-700 font-medium">
                            <ul class="list-disc list-inside text-left">
                                        @if($customer->pembayaran->isNotEmpty())
                                <ul>
                                    @foreach($customer->pembayaran as $pembayaran)
                                        @if($pembayaran->bayar > 0)
                                            <li>
                                                Rp {{ number_format($pembayaran->bayar, 0, ',', '.') }}<br>
                                                <small class="text-gray-500">{{ \Carbon\Carbon::parse($pembayaran->tanggalBayar)->format('d M Y') }}</small>
                                            </li>
                                        @endif
                                    @endforeach
                                </ul>
                            @endif


                                                        </ul>
                                                    </td>

                                    <td class="p-3 border text-center">
                                        <a href="{{ route('reports.edit', $customer->idCustomer) }}"
                                           class="inline-flex items-center px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded shadow transition">
                                            💳 Bayar
                                        </a>
                                        {{-- <a href="{{ route('reports.cetakhutang', $customer->idCustomer) }}"
                                            target="_blank"
                                            class="inline-flex items-center px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded shadow transition">
                                            🖨️ Cetak
                                            </a> --}}

                                    </td>
                                </tr>
                            @endif
                        @empty
                            <tr>
                                <td colspan="7" class="p-4 text-center text-gray-500 italic">
                                    Tidak ada pelanggan dengan cicilan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>