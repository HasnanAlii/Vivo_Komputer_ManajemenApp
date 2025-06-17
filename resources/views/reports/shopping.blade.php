<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
             <button type="button" onclick="window.location='{{ route('reports.index') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                </button>
            <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                Daftar Belanja Toko
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-full mx-auto sm:px-6 lg:px-8">
           <div class="bg-white shadow-xl sm:rounded-lg p-6 overflow-x-auto">
            <div class="flex justify-end mb-4">
                <a href="{{ route('reports.shoppingcreate') }}" 
                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-4 py-2 rounded shadow transition">
                + Tambah Data
                </a>
            </div>
                        @if ($shoppings->isEmpty())
                    <p class="text-gray-500 italic">Belum ada data belanja toko.</p>
                @else
                    <table class="min-w-full table-auto border border-gray-200 text-gray-800">
                     <thead class="bg-gray-100 text-left text-sm font-semibold text-gray-700">
                <tr>
                    <th class="p-3 border">No</th>
                    <th class="p-3 border">Sumber</th>
                    <th class="p-3 border">Jumlah</th>
                    <th class="p-3 border">Total Belanja</th>
                    <th class="p-3 border">Sisa Cicilan</th> <!-- Baru -->
                    <th class="p-3 border">Bayar</th> <!-- Baru -->
                    <th class="p-3 border">Status Pembayaran</th>
                    <th class="p-3 border text-center">Aksi</th>
                </tr>
            </thead>

                                    <tbody class="text-sm">
                @foreach ($shoppings as $shopping)
                    <tr class="hover:bg-gray-50">
                        <td class="p-3 border text-center">{{ $loop->iteration }}</td>
                        <td class="p-3 border">{{ $shopping->sumber }}</td>
                        <td class="p-3 border format-ribuan">{{ $shopping->jumlah }}</td>
                        <td class="p-3 border format-ribuan">Rp {{ number_format($shopping->totalbelanja, 0, ',', '.') }}</td>
                
                        <td class="p-3 border format-ribuan">
                            @if ($shopping->cicilanTerakhir)
                                Rp {{ number_format($shopping->cicilanTerakhir->sisaCicilan, 0, ',', '.') }}
                            @else
                                -
                            @endif
                        </td>
                    <td class="p-3 border text-sm text-green-700 font-medium">
                        @if($shopping->pembayaranCicilan && $shopping->pembayaranCicilan->isNotEmpty())
                            <ul class="list-disc list-inside text-left space-y-1">
                                @foreach($shopping->pembayaranCicilan as $pembayaran)
                                    @if($pembayaran->bayar > 0)
                                        <li>
                                            Rp {{ number_format($pembayaran->bayar, 0, ',', '.') }}<br>
                                            <small class="text-gray-500">
                                                {{ \Carbon\Carbon::parse($pembayaran->tanggalBayar)->format('d M Y') }}
                                            </small>
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        @else
                            <span class="text-gray-400 italic">Belum ada cicilan</span>
                        @endif
                    </td>

                        <td class="p-3 border">
                            @if ($shopping->statuspembayaran)
                                <span class="text-green-600 font-semibold">Lunas</span>
                            @else
                                <span class="text-red-600 font-semibold">Belum Lunas</span>
                            @endif
                        </td>
                        <td class="p-3 border text-center space-x-1 whitespace-nowrap">
                            <a href="{{ route('reports.edits', $shopping->id) }}"
                             class="inline-flex items-center px-3 py-1 bg-green-500 hover:bg-green-600 text-white text-sm font-medium rounded shadow transition">
                                            💳 Bayar
                            </a>

                            <form action="{{ route('reports.destroysh', $shopping->id) }}"
                                method="POST"
                                onsubmit="return confirm('Yakin ingin menghapus data ini?')"
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
          <script>
  document.querySelectorAll('.format-ribuan').forEach(function(input) {
    input.addEventListener('input', function(e) {
      // Hapus semua titik dulu
      let value = e.target.value.replace(/\./g, '').replace(/[^0-9]/g, '');
      // Format angka dengan pemisah ribuan
      e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
  });
</script>
</x-app-layout>
