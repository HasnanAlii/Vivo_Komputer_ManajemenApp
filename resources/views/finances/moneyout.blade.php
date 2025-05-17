<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center space-x-2">
            <span>📊</span>
            <span>Halaman Keuangan</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            
            <!-- Table Card -->
            <div class="bg-white shadow rounded-lg p-6">
                
                <!-- Filter Form -->
              <div class="flex items-center mb-6 space-x-4">
    <!-- Tombol Back di kiri -->
    <button type="button" onclick="window.location='{{ route('finances.index') }}'"
        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
        🔙
    </button>

    <!-- Spacer supaya filter dan tombol tambah ke kanan -->
    <div class="flex-grow"></div>
     <a href="{{ route('finances.printt', ['filter' => $filter, 'date' => $date]) }}"
                class="bg-red-500 hover:bg-red-800 text-white font-semibold px-4 py-2 rounded shadow inline-flex items-center gap-2">
                🖨️ Export PDF
            </a>

    <!-- Filter Form di kanan -->
    <form method="GET" action="{{ route('finances.indexx') }}" class="flex space-x-4 items-center">
        {{-- <label for="filter" class="font-medium">Filter:</label> --}}
        <select name="filter" id="filter" onchange="this.form.submit()" class="border rounded px-3 py-2">
            <option value="harian" {{ $filter == 'harian' ? 'selected' : '' }}>Harian</option>
            <option value="mingguan" {{ $filter == 'mingguan' ? 'selected' : '' }}>Mingguan</option>
            <option value="bulanan" {{ $filter == 'bulanan' ? 'selected' : '' }}>Bulanan</option>
            <option value="tahunan" {{ $filter == 'tahunan' ? 'selected' : '' }}>Tahunan</option>
        </select>

        <input type="date" name="date" value="{{ $date }}" onchange="this.form.submit()" class="border rounded px-3 py-2">

        <noscript>
            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Filter</button>
        </noscript>
    </form>

    {{-- Tombol Tambah Pengeluaran di kanan --}}
                <div x-data="{ showModal: false }" class="ml-4">
                    <button 
                        @click="showModal = true"
                        class="bg-blue-500 hover:bg-blue-700 text-white px-5 py-2 rounded-lg font-semibold shadow flex items-center gap-2">
                        <span>➕</span> Tambah Pengeluaran
                    </button>

                    <!-- Modal Dana Keluar -->
                    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
                        <div @click.away="showModal = false" class="bg-white rounded-xl shadow-lg w-[400px] p-6">
                            <h2 class="text-xl font-bold mb-4 text-grey-700">📤 Tambah Dana Keluar</h2>
                            <form action="{{ route('finances.store') }}" method="POST">
                                @csrf
                                <input type="hidden" name="tipe" value="keluar">
                                <x-text-input label="Keterangan" name="keterangan" />
                                <x-number-input label="Jumlah (Rp)" name="jumlah" />
                                <x-date-input label="Tanggal" name="tanggal" :value="date('Y-m-d')" />
                                <x-modal-buttons @close="showModal = false" color="blue"/>
                            </form>
                        </div>
                    </div>
                </div>
            </div>


                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-blue-100">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">NO</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Keterangan</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Jumlah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-700 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($MoneyOut as $record)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $loop->iteration }}</td>
                                <td class="px-6 py-4 whitespace-nowrap italic text-gray-600">{{ $record->keterangan }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-green-600 font-semibold">
                                    Rp {{ number_format($record->jumlah, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">{{ $record->tanggal->format('d-m-Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-4 text-center text-gray-500">Data tidak ditemukan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- Summary Section -->
                <div class="mt-6 bg-blue-50 p-4 rounded flex justify-end items-center space-x-6 text-xl">
                    <div class="text-grey-600 font-semibold flex items-center space-x-1">
                        <span>💰</span>
                        <span>Total Pengeluaran:</span>
                        <span>Rp {{ number_format($totalPengeluaran ?? 0, 0, ',', '.') }}</span>
                    </div>
                    
                </div>
                 <div class="mt-4 ">
              {{ $MoneyOut->links('vendor.pagination.custom') }}
               </div>

            </div>
        </div>
    </div>
</x-app-layout>
