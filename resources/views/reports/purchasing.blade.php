<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
             <button type="button" onclick="window.location='{{ route('reports.index') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                </button>
            <h2 class="font-bold text-2xl text-gray-800">Daftar Pembelian</h2>
        </div>
    </x-slot>

    <div class="py-4">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow-lg sm:rounded-lg p-6">

                {{-- Flash Message --}}
                @if(session('success'))
                    <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                {{-- Filter & PDF --}}
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-4 gap-4">
                    <form action="{{ route('reports.purchasings') }}" method="GET" class="flex items-center gap-2">
                        <label for="filter" class="text-sm text-gray-600">Filter:</label>
                        <select name="filter" id="filter" onchange="this.form.submit()" class="rounded border-gray-300 text-sm">
                            <option value="">-- Semua --</option>
                            <option value="today" {{ request('filter') == 'today' ? 'selected' : '' }}>Harian</option>
                            <option value="week" {{ request('filter') == 'week' ? 'selected' : '' }}>Mingguan</option>
                            <option value="month" {{ request('filter') == 'month' ? 'selected' : '' }}>Bulanan</option>
                            <option value="year" {{ request('filter') == 'year' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </form>

                    <a href="{{ route('reports.print', ['filter' => request('filter')]) }}" 
                       class="inline-block px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 text-sm">
                        Cetak PDF
                    </a>
                </div>

                {{-- Tabel --}}
                <div class="bg-white shadow rounded-lg overflow-x-auto">
                    <table class="min-w-full text-sm border border-gray-200 rounded-lg shadow-sm">
                        <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                            <tr>
                                <th class="p-3 border">NO</th>
                                <th class="p-3 border">Nama Penjual</th>
                                <th class="p-3 border">Nama Barang</th>
                                <th class="p-3 border">Jumlah</th>
                                <th class="p-3 border">Harga Beli</th>
                                <th class="p-3 border">Harga Jual</th>
                                <th class="p-3 border">Keuntungan</th>
                                <th class="p-3 border">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @forelse($purchasings as $p)
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-2 border text-center">{{ $loop->iteration }}</td>
                                    <td class="p-3 border">{{ $p->customer->nama ?? '-' }}</td>
                                    <td class="p-3 border">{{ $p->product->namaBarang ?? '-' }}</td>
                                    <td class="p-3 border">{{ $p->jumlah }}</td>
                                    <td class="p-3 border">Rp {{ number_format($p->hargaBeli, 0, ',', '.') }}</td>
                                    <td class="p-3 border">Rp {{ number_format($p->hargaJual, 0, ',', '.') }}</td>
                                    <td class="p-3 border">Rp {{ number_format($p->keuntungan, 0, ',', '.') }}</td>
                                    <td class="p-3 border">{{ \Carbon\Carbon::parse($p->tanggal)->format('d-m-Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="p-4 text-center text-gray-500">Belum ada data pembelian.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    {{-- Ringkasan Total --}}
                </div>
                <div class="mt-4 ">
                    {{ $purchasings->links('vendor.pagination.custom') }}
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
    </div>
</x-app-layout>
