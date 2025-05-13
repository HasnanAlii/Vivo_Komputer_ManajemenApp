<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Halaman Kasir') }}
            </h2>
            <!-- Kotak Pencarian -->
            <form action="{{ route('sales.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Cari Produk..." value="{{ request('search') }}"
                    class="pl-3 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring">
            </form>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Daftar Produk -->
            <div class="col-span-2 bg-white p-6 rounded-lg shadow">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Nama Produk</th>
                            <th class="px-4 py-2 text-left">Harga</th>
                            <th class="px-4 py-2 text-left">Jumlah</th>
                            <th class="px-4 py-2 text-left">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @forelse ($sales as $sale)
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2">{{ $sale->product->namaBarang }}</td>
                                <td class="px-4 py-2">Rp {{ number_format($sale->product->hargaJual, 0, ',', '.') }}</td>
                                <td class="px-4 py-2">{{ $sale->jumlah }}</td>
                                <td class="space-x-1 flex items-center p-1">
                             
                                <!-- Tombol - -->
                                <form action="{{ route('sales.decrease', $sale->idSale) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-yellow-400 text-white px-2 py-1 rounded">-</button>
                                </form>

                                <span class="px-2">{{ $sale->jumlah }}</span>

                                <!-- Tombol + -->
                                <form action="{{ route('sales.increase', $sale->idSale) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-blue-500 text-white px-2 py-1 rounded">+</button>
                                </form>

                                <!-- Tombol hapus -->
                                <form action="{{ route('sales.destroy', $sale->idSale) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white px-2 py-1 rounded ml-2">🗑</button>
                                </form>

                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-4 py-2 text-center text-gray-500">Tidak ada data penjualan.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Ringkasan Transaksi -->
          <div class="bg-white p-6 rounded-lg shadow space-y-6">
                @php
                    $subTotal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaJual);
                    $total = $subTotal; // Total without discount
                @endphp

                <div class="flex justify-between items-center">
                    <label class="text-sm text-gray-600">Sub Total</label>
                    <p class="text-lg font-semibold">Rp. {{ number_format($subTotal, 0, ',', '.') }}</p>
                </div>

                <!-- List of Purchased Products -->
                <div>
                    <label class="text-sm text-gray-600">Barang yang Dibeli</label>
                    <ul class="space-y-2">
                        @foreach ($sales as $sale)
                            <li class="flex justify-between">
                                <span>{{ $sale->product->namaBarang }} ({{ $sale->jumlah }} x)</span>
                                <span>Rp {{ number_format($sale->product->hargaJual * $sale->jumlah, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex justify-between items-center">
                    <label class="text-sm text-gray-600">Total</label>
                    <p class="text-lg font-semibold text-green-600">Rp. {{ number_format($total, 0, ',', '.') }}</p>
                </div>

                <form method="POST">
                        @csrf
                        <div class="space-y-4">
                            <div>
                                <label class="text-sm text-gray-600">Bayar</label>
                                <div class="flex items-center space-x-2">
                                    <input type="number" name="bayar" id="bayar-input" 
                                        class="w-full px-3 py-2 border rounded" 
                                        value="{{ old('bayar', $total) }}" 
                                        oninput="updateKembalian()"
                                        onkeydown="if(event.key === 'Enter'){ event.preventDefault(); return false; }" />

                                    <button 
                                        type="submit" 
                                        formaction="{{ route('sales.checkout') }}"
                                        class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded">
                                        Checkout
                                    </button>
                                </div>
                            <p class="text-blue-500 text-xs mt-1 cursor-pointer" onclick="setExact()">Uang Pas</p>
                        </div>

<div class="max-w-7xl mx-auto mb-4">
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
            {{ session('error') }}
        </div>
    @endif
</div>

                        <div>
                            <label class="text-sm text-gray-600">Kembalian</label>
                            <p id="kembalian-output" class="text-lg font-semibold text-gray-600">
                                Rp. {{ number_format((old('bayar', $total) - $total), 0, ',', '.') }}
                            </p>
                        </div>

                        <input type="hidden" name="total" value="{{ $total }}">

                        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded hover:bg-blue-700">
                            Cetak Nota
                        </button>
                    </div>
                </form>
            </div>

            <script>
                function updateKembalian() {
                    const bayarInput = document.getElementById('bayar-input');
                    const kembalianOutput = document.getElementById('kembalian-output');
                    const total = {{ $total }};
                    
                    // Get the amount entered by the user
                    const bayar = parseFloat(bayarInput.value) || 0;

                    // Calculate the kembalian (change)
                    const kembalian = bayar - total;

                    // Update the kembalian field with the calculated value
                    kembalianOutput.textContent = 'Rp. ' + kembalian.toLocaleString('id-ID');
                }

                function setExact() {
                    // Set the "Bayar" amount to the total amount, simulating an exact payment
                    const bayarInput = document.getElementById('bayar-input');
                    bayarInput.value = {{ $total }};
                    updateKembalian(); // Update kembalian after setting the exact amount
                }
            </script>

</x-app-layout>
