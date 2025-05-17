<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center space-x-2">
            <button type="button" onclick="window.location='{{ route('dashboard') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                </button>
            <span>📊</span>
            <span>Halaman Keuangan</span>
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-white shadow-lg rounded-xl p-6 border border-gray-200 space-y-6">
    {{-- Tombol Aksi --}}
    <div class="flex flex-wrap justify-between gap-4">
        {{-- Tombol Dana Masuk --}}
        <div x-data="{ showDanaMasuk: false }">
            <button 
                @click="showDanaMasuk = true"
                class="bg-green-400 hover:bg-green-700 text-white px-5 py-2 rounded-lg font-semibold shadow flex items-center gap-2">
                <span>➕</span> Tambah Modal
            </button>
            
            <!-- Modal Dana Masuk -->
            <div x-show="showDanaMasuk" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
                <div @click.away="showDanaMasuk = false" class="bg-white rounded-xl shadow-lg w-[400px] p-6">
                    <h2 class="text-xl font-bold mb-4 text-green-700">💸 Tambah Dana Masuk</h2>
                    <form action="{{ route('finances.storee') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tipe" value="masuk">
                        <x-text-input label="Keterangan" name="keterangan" />
                        <x-number-input label="Jumlah (Rp)" name="jumlah" />
                        <x-date-input label="Tanggal" name="tanggal" :value="date('Y-m-d')" />
           
                        <x-modal-buttons @close="showDanaMasuk = false" color="green"/>
                    </form>  
                </div>
               
            </div>
        </div>
        <div class="flex justify-end items-center space-x-4">
             <a href="{{ route('finances.print', ['filter' => $filter, 'date' => $date]) }}"
                class="bg-red-500 hover:bg-red-800 text-white font-semibold px-4 py-2 rounded shadow inline-flex items-center gap-2">
                🖨️ Export PDF
            </a>
                <form method="GET" action="{{ route('finances.index') }}" class="flex space-x-4 items-center">
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
            <a href="{{ route('finances.indexx') }}"
                class="inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                <span class="ml-2">Lihat Pengeluaran</span>
            </a>

         
            </div>

    </div>

    {{-- Tabel Data Keuangan --}}
    <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-300 divide-y divide-gray-200 rounded-md overflow-hidden text-sm">
            <thead class="bg-blue-100 text-blue-900 uppercase text-xs font-bold">
                <tr>
                    <th class="p-3">NO</th>
                    <th class="p-3 text-left">Aliran Dana</th>
                    <th class="p-3 text-left">Modal</th>
                    <th class="p-3 text-left">Keuntungan</th>
                    <th class="p-3 text-left">Total transaksi</th>
                    <th class="p-3 text-left">Keterangan</th>
                    <th class="p-3 text-left">No Faktur</th>
                    <th class="p-3">Tanggal</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse ($finances as $finance)
                    <tr class="hover:bg-blue-50 transition-colors duration-200">
                        <td class="p-3 text-center">{{ $loop->iteration }}</td>
                        <td class="p-3 text-green-600 font-semibold text-left">Rp {{ number_format($finance->dana, 0, ',', '.') }}</td>
                        <td class="p-3 text-red-500 font-semibold text-left">Rp {{ number_format($finance->modal, 0, ',', '.') }}</td>
                        <td class="p-3 text-blue-500 font-semibold text-left">Rp {{ number_format($finance->keuntungan, 0, ',', '.') }}</td>
                        <td class="p-3 font-bold text-gray-800 text-left">Rp {{ number_format($finance->totalDana, 0, ',', '.') }}</td>
                        <td class="p-3 italic text-gray-600">{{ $finance->keterangan }}</td>
                       <td class="p-3 italic text-gray-600">
                            @if($finance->purchasings)
                                {{ $finance->purchasings->nomorFaktur }}
                            @elseif($finance->sales)
                                {{ $finance->sales->nomorFaktur }}
                            @elseif($finance->services)
                                {{ $finance->services->nomorFaktur }}
                            @endif
                        </td>



                        <td class="p-3 text-gray-500 text-center">{{ \Carbon\Carbon::parse($finance->tanggal)->format('d-m-Y') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="p-4 text-center text-gray-500 italic">Tidak ada data keuangan.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4 ">
  {{ $finances->links('vendor.pagination.custom') }}
   </div>
    {{-- Ringkasan Total --}}
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
            <span>Total Dana:</span>
            <span>Rp {{ number_format($totalDana, 0, ',', '.') }}</span>
        </div>
    </div>
</div>


</x-app-layout>
