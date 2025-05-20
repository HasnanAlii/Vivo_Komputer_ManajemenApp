<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              <button type="button" onclick="window.location='{{ route('dashboard') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                </button>
            {{ __('Data Service Barang') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-screen-2xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 px-4 py-2 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-md sm:rounded-lg p-6">
                <div class="flex justify-between items-center mb-4">
                   <form method="GET" action="{{ route('service.index') }}" class="mb-4 flex items-center gap-4">
    <label for="filter" class="font-semibold text-gray-700">Filter Waktu:</label>
    <select name="filter" id="filter" class="border rounded pr-8 py-1">
        <option value="" {{ request('filter') == '' ? 'selected' : '' }}>Semua</option>
        <option value="harian" {{ request('filter') == 'harian' ? 'selected' : '' }}>Harian</option>
        <option value="mingguan" {{ request('filter') == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
        <option value="bulanan" {{ request('filter') == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
    </select>

    {{-- Input Pencarian Nomor Faktur --}}
    <input type="text" name="cari_faktur" placeholder="Cari Nomor Faktur" 
           value="{{ request('cari_faktur') }}"
           class="border rounded px-3 py-1 text-sm focus:outline-none focus:ring focus:border-blue-300">

    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-1 rounded shadow">
        Filter
    </button>
</form>

                    <a href="{{ route('service.menu') }}" 
                       class="bg-green-600 hover:bg-green-700 text-white font-semibold py-2 px-4 rounded inline-flex items-center shadow">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Service Baru
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 text-gray-600 uppercase text-xs font-semibold">
                            <tr>
                                <th class="px-4 py-2 border">NO Faktur</th>
                                <th class="px-4 py-2 border">Nama Pelanggan</th>
                                <th class="px-4 py-2 border">Barang</th>
                                <th class="px-4 py-2 border">Kerusakan</th>
                                <th class="px-4 py-2 border">Kelengkapan</th>
                                <th class="px-4 py-2 border">Kondisi awal</th>
                                <th class="px-4 py-2 border">Sparepart Digunakan</th>
                                <th class="px-4 py-2 border">Biaya Service</th>
                                <th class="px-4 py-2 border">Tgl Masuk</th>
                                <th class="px-4 py-2 border">Tgl Selesai</th>
                                <th class="px-4 py-2 border">Status</th>
                                <th class="px-4 py-2 border text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @forelse ($services as $index => $service)
                                <tr class="hover:bg-gray-50 transition">
                                    <td class="px-4 py-2 border text-center">{{ $service->nomorFaktur }}</td>
                                    <td class="px-4 py-2 border">{{ $service->customer->nama }}</td>
                                    <td class="px-4 py-2 border">{{ $service->jenisPerangkat }}</td>
                                    <td class="px-4 py-2 border">{{ $service->kerusakan ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $service->kelengkapan?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ $service->kondisi ?? '-' }}</td>

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
                                    <td class="px-5 py-2 border text-center">
    <div class="flex justify-center gap-2">
        <!-- Tombol Update -->
        <a href="{{ route('service.edit', $service->idService) }}" 
           class="flex items-center gap-1 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded text-sm shadow transition">
            ✏️ <span>Update</span>
        </a>

        <!-- Tombol Cetak Struk -->
        <button type="button" 
                onclick="window.location='{{ route('service.struk', ['id' => $service->idService]) }}'" 
                class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm shadow transition">
            🧾 <span>Struk</span>
        </button>
         <button type="button" 
                onclick="window.location='{{ route('service.label', ['id' => $service->idService]) }}'" 
                class="flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded text-sm shadow transition">
            🧾 <span>label</span>
        </button>
        
    </div>
</td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center text-gray-500 py-6">Tidak ada data perbaikan.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 ">
                          {{ $services->links('vendor.pagination.custom') }}
                </div>
                
            </div>
        </div>
    </div>
</x-app-layout>
