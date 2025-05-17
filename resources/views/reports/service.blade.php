<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Data Perbaikan Barang') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                 {{-- Filter & PDF --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                    <form action="{{ route('reports.services') }}" method="GET" class="flex items-center gap-2">
                        <label for="filter" class="text-sm text-gray-600">Filter:</label>
                        <select name="filter" id="filter" onchange="this.form.submit()" class="rounded border-gray-300 text-sm">
                            <option value="">-- Semua --</option>
                            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Harian</option>
                            <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Mingguan</option>
                            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Bulanan</option>
                            <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </form>

                    <a href="{{ route('reports.printtt', ['filter' => request('filter')]) }}" 
                       class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                        Cetak PDF
                    </a>
                </div>
               
                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-4 py-2 border">NO</th>
                                <th class="px-4 py-2 border">Nama Pelanggan</th>
                                <th class="px-4 py-2 border">Barang</th>
                                <th class="px-4 py-2 border">Kerusakan</th>
                                <th class="px-4 py-2 border">Sparepart Digunakan</th>
                                <th class="px-4 py-2 border">Biaya Service</th>
                                <th class="px-4 py-2 border">Tgl Masuk</th>
                                <th class="px-4 py-2 border">Tgl Selesai</th>
                                <th class="px-4 py-2 border">Status</th>
                               
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($services as $index => $service)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 border text-center">{{ $index + 1 }}</td>
                                    <td class="px-4 py-2 border">{{ $service->customer->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $service->jenisPerangkat }}</td>
                                    <td class="px-4 py-2 border">{{ $service->kerusakan ?? '-' }}</td>
                                 <td class="px-4 py-2 border">
                                    @if($service->products->isNotEmpty())
                                        {{ $service->products->pluck('namaBarang')->join(', ') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                    <td class="px-4 py-2 border">{{ $service->totalHarga }}</td>

                                    <td class="px-4 py-2 border">{{ $service->tglMasuk }}</td>
                                    <td class="px-4 py-2 border">{{ $service->tglSelesai ?? '-' }}</td>
                                    <td class="px-4 py-2 border text-center">
                                        @if ($service->status)
                                            <span class="inline-block bg-green-100 text-green-800 text-xs px-2 py-1 rounded-full font-semibold">Selesai</span>
                                        @else
                                            <span class="inline-block bg-yellow-100 text-yellow-800 text-xs px-2 py-1 rounded-full font-semibold">Proses</span>
                                        @endif
                                    </td>
                                   
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-gray-500 py-6">Tidak ada data perbaikan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4 ">
                     {{ $services->links('vendor.pagination.custom') }}
                     </div>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>
