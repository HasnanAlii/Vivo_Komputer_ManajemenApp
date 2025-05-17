<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <button type="button" onclick="window.location='{{ route('reports.index') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                </button>
            {{ __('Laporan Penjualan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">


                {{-- Filter & PDF --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                    <form action="{{ route('reports.sales') }}" method="GET" class="flex items-center gap-2">
                        <label for="filter" class="text-sm text-gray-600">Filter:</label>
                        <select name="filter" id="filter" onchange="this.form.submit()" class="rounded border-gray-300 text-sm">
                            <option value="">-- Semua --</option>
                            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Harian</option>
                            <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Mingguan</option>
                            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Bulanan</option>
                            <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </form>

                    <a href="{{ route('reports.printt', ['filter' => request('filter')]) }}" 
                       class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                        Cetak PDF
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-4 py-2 border">NO</th>
                                <th class="px-4 py-2 border text-center">Nomor Faktur</th>
                                <th class="px-4 py-2 border text-left">Produk</th>
                                <th class="px-4 py-2 border text-left">Kategori Produk</th>
                                <th class="px-4 py-2 border">Jumlah</th>
                                <th class="px-4 py-2 border text-left">Keuntungan</th>

                                <th class="px-4 py-2 border text-left">Total Harga</th>
                                <th class="px-4 py-2 border text-center">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($sales as $index => $item)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $item->nomorFaktur }}</td>
                                    <td class="px-4 py-2 border">{{ $item->product->namaBarang ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $item->product->category->namaKategori ?? '-' }}</td>
                                    <td class="px-4 py-2 border text-center">{{ $item->jumlah }}</td>
                                   
                                    <td class="px-4 py-2 border text-blue-600 font-semibold"> Rp {{ number_format($item->keuntungan, 0, ',', '.') }}</td>
                                    <td class="px-4 py-2 border text-green-600 font-semibold">
                                        Rp {{ number_format($item->totalHarga, 0, ',', '.') }}
                                    </td>
                                    <td class="px-4 py-2 border text-center">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-gray-500 py-6">
                                        Tidak ada data penjualan.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                     <div class="mt-4 ">
                     {{ $sales ->links('vendor.pagination.custom') }}
                     </div>
                      <div class="mt-6 p-5 bg-blue-50 rounded-lg grid grid-cols-1 md:grid-cols-3 gap-6 text-lg font-semibold shadow-inner ">
                    <div class="mx-auto flex items-center space-x-2 text-red-700">
                        <span class="text-2xl">💰</span>
                        <span>Total Modal:</span>
                        <span>Rp {{ number_format($totalModal, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-blue-700">
                        <span class="text-2xl">📈</span>
                        <span>Total Keuntungan:</span>
                        <span>Rp {{ number_format($totalKeuntungan, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex items-center space-x-2 text-green-700">
                        <span class="text-2xl">💰</span>
                        <span>Total Pendapatan:</span>
                        <span>Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</span>
                    </div>
                </div>
                  
                </div>
                
        </div>
    </div>
</x-app-layout>
