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
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-gray-700">Daftar Service</h3>
                    <a href="{{ route('service.create') }}" 
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
                                <th class="px-4 py-2 border">NO</th>
                                <th class="px-4 py-2 border">Nama Pelanggan</th>
                                <th class="px-4 py-2 border">Barang</th>
                                <th class="px-4 py-2 border">Kerusakan</th>
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
                                    <td class="px-5  flex py-2 border justify-center text-center">
                                        <a href="{{ route('service.edit', $service->idService) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs shadow">
                                            ✏️ Update
                                        </a>
                                           {{-- <a href="{{ route('service.edit', $service->idService) }}" 
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-2 py-1 rounded text-xs shadow">
                                            ✏️Print
                                        </a> --}}
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
