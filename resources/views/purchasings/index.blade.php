<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            
            <h2 class="font-bold text-2xl text-gray-800">Daftar Pembelian</h2>
        </div>
    </x-slot>

   <div class="py-4">
       <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-white shadow-lg sm:rounded-lg p-6">
               <div class="flex justify-end items-center mb-6">
         
            <a href="{{ route('purchasing.create') }}" class="mt-2 inline-block bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                + Tambah Pembelian
            </a>
        </div>
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-300 text-green-700 px-4 py-2 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class=" bg-white shadow rounded-lg flex items-center">
            <table class="min-w-full table-auto border  border-gray-200">
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
                            <td class="px-4 py-2">{{ $loop->iteration }}</td>
                            <td class="p-3 border">{{ $p->customer->nama ?? '-' }}</td>
                            <td class="p-3 border">{{ $p->product->namaBarang ?? '-' }}</td>
                            <td class="p-3 border">{{ $p->jumlah }}</td>
                            <td class="p-3 border">Rp {{ number_format($p->hargaBeli, 0, ',', '.') }}</td>
                            <td class="p-3 border">Rp {{ number_format($p->hargaJual, 0, ',', '.') }}</td>
                            <td class="p-3 border">Rp {{ number_format($p->keuntungan, 0, ',', '.') }}</td>
                            <td class="p-3 border">{{ $p->tanggal }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="11" class="p-4 text-center text-gray-500">Belum ada data pembelian.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
       </div>
</x-app-layout>
