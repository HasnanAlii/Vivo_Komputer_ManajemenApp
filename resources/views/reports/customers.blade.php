<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <button type="button" onclick="window.location='{{ route('reports.index') }}'"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow transition">
                🔙 
            </button>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Kelola Pelanggan
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-xl sm:rounded-lg p-6 overflow-x-auto">
                @if ($customers->isEmpty())
                    <p class="text-gray-500 italic">Belum ada data pelanggan.</p>
                @else
                    <table class="min-w-full table-auto border border-gray-200 text-gray-800">
                        <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                            <tr>
                                <th class="p-3 border">No</th>
                                <th class="p-3 border">Nama</th>
                                <th class="p-3 border">No HP</th>
                                <th class="p-3 border">Alamat</th>
                                <th class="p-3 border">No KTP</th>
                                <th class="p-3 border">Riwayat Service</th>
                                <th class="p-3 border">Riwayat Penjualan</th>
                                {{-- <th class="p-3 border">Riwayat Pembelian</th> --}}

                                {{-- <th class="p-3 border text-center">Cicilan</th>
                                <th class="p-3 border text-center">Sisa Cicilan</th> --}}

                                <th class="p-3 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm">
                            @foreach ($customers as $customer)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border text-center">{{ $loop->iteration }}</td>
                                    <td class="p-3 border">{{ $customer->nama }}</td>
                                    <td class="p-3 border">{{ $customer->noTelp }}</td>
                                    <td class="p-3 border">{{ $customer->alamat }}</td>
                                    <td class="p-3 border">{{ $customer->noKtp }}</td>

                                    <td class="p-3 border">
                                        @if ($customer->services->isEmpty())
                                            <span class="text-gray-400 italic">- Tidak ada</span>
                                        @else
                                            <ul class="list-disc list-inside max-h-32 overflow-y-auto">
                                                @foreach ($customer->services as $service)
                                                    <li>
                                                        {{ $service->kerusakan }} 
                                                        (<span class="capitalize">{{ $service->status }}</span>)
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    
                                </td>
                                
                                <td class="p-3 border text-green-700">
                                    @if($customer->purchasings->isEmpty())
                                      <span class="text-gray-400 italic">- Tidak ada</span>
                                    @else
                                    <ul class="list-disc list-inside text-left">
                                        @foreach ($customer->purchasings as $purchase)
                                        <li>{{ $purchase->product->namaBarang }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </td>
                                {{-- <td class="p-3 border text-center font-semibold text-green-700">
                                    @if($customer->sales->isEmpty())
                                    -
                                    @else
                                    <ul class="list-disc list-inside text-left">
                                        @foreach ($customer->sales as $purchase)
                                        <li>{{ $purchase->product->namaBarang }}</li>
                                        @endforeach
                                    </ul>
                                    @endif
                                </td> --}}
                               {{-- <td class="p-3 border text-center font-semibold text-green-700">
                                    @if($customer->cicilan == 0)
                                        -
                                    @else
                                        <ul class="list-disc list-inside text-left">
                                            @foreach ($customer->sales as $purchase)
                                                <li>{{ $purchase->product->namaBarang }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </td> --}}

                                {{-- <td class="p-3 border text-center font-semibold text-green-700">
                                    {{ number_format($customer->cicilan ?? 0, 0, ',', '.') }}
                                </td> --}}

                                    <td class="p-3 border text-center space-x-1 whitespace-nowrap">
                                        @if ($customer->cicilan > 0)
                                            <a href="{{ route('reports.edit', $customer->idCustomer) }}"
                                               class="inline-flex items-center px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded shadow transition duration-150">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M11 5h6M11 9h4M5 15h14M5 19h10M4 4h16a1 1 0 011 1v14a1 1 0 01-1 1H4a1 1 0 01-1-1V5a1 1 0 011-1z" />
                                                </svg>
                                                Bayar
                                            </a>
                                        @endif

                                        <a href="{{ route('reports.editt', $customer->idCustomer) }}"
                                           class="inline-flex items-center px-3 py-1 bg-yellow-500 hover:bg-yellow-600 text-white text-sm font-medium rounded shadow transition duration-150">
                                            ✏️ Edit
                                        </a>

                                        <form action="{{ route('reports.destroyy', $customer->idCustomer) }}"
                                              method="POST"
                                              onsubmit="return confirm('Yakin ingin menghapus customer ini?')"
                                              class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow transition">
                                                🗑️
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
