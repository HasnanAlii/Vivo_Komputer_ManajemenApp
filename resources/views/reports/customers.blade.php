<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <button type="button" onclick="window.location='{{ route('reports.index') }}'"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                🔙
            </button>
            {{ __(' Kelola Pelanggan') }}
        </h2>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                @if ($customers->isEmpty())
                    <p class="text-gray-500">Belum ada data pelanggan.</p>
                @else
                    <table class="min-w-full table-auto border border-gray-200">
                        <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                            <tr>
                                <th class="p-3 border">No</th>
                                <th class="p-3 border">Nama</th>
                                <th class="p-3 border">No HP</th>
                                <th class="p-3 border">Alamat</th>
                                <th class="p-3 border">No KTP</th>
                                <th class="p-3 border">Riwayat Service</th>
                                <th class="p-3 border">Riwayat Penjualan</th>
                                <th class="p-3 border">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm text-gray-800">
                            @foreach ($customers as $customer)
                                <tr class="hover:bg-gray-50">
                                    <td class="p-3 border">{{ $loop->iteration }}</td>
                                    <td class="p-3 border">{{ $customer->nama }}</td>
                                    <td class="p-3 border">{{ $customer->noTelp }}</td>
                                    <td class="p-3 border">{{ $customer->alamat }}</td>
                                    <td class="p-3 border">{{ $customer->noKtp }}</td>
                                    <td class="p-3 border">
                                        @if($customer->services->isEmpty())
                                            <span class="text-gray-400 italic">- Tidak ada</span>
                                        @else
                                            <ul class="list-disc list-inside">
                                                @foreach ($customer->services as $service)
                                                    <li>
                                                        {{ $service->kerusakan }} 
                                                        ({{ ucfirst($service->status) }})
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class="p-3 border">
                                        @if($customer->purchasings->isEmpty())
                                            <span class="text-gray-400 italic">- Tidak ada</span>
                                        @else
                                            <ul class="list-disc list-inside">
                                                @foreach ($customer->purchasings as $purchase)
                                                    <li>
                                                        {{ $purchase->product->namaBarang }} - 
                                                        Rp{{ number_format($purchase->totalHarga, 0, ',', '.') }}
                                                    </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class="p-3 border text-center">
                                        <form action="{{ route('reports.destroyy', $customer->idCustomer) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus customer ini?')" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow transition">
                                                🗑️ <span class="ml-1">Hapus</span>
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
