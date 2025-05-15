<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800">Halaman Kasir</h2>
            <form action="{{ route('sales.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Cari Produk..." value="{{ request('search') }}"
                    class="pl-3 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            </form>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">

            <!-- Produk -->
            <div class="col-span-2 bg-white p-6 rounded-xl shadow-md">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr class="text-gray-700 text-sm">
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Nama Produk</th>
                            <th class="px-4 py-2 text-center">Harga</th>
                            <th class="px-4 py-2 text-center">Jumlah</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($sales as $sale)
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 font-medium">{{ $sale->product->namaBarang }}</td>
                                <td class="px-4 py-2 text-grey-600 text-center" >Rp {{ number_format($sale->product->hargaJual, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 text-center">{{ $sale->jumlah }}</td>
                                <td class="flex space-x-2 items-center px-4 py-2 justify-center">
                                    <form action="{{ route('sales.decrease', $sale->idSale) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow-sm">-</button>
                                    </form>

                                    <span class="font-semibold">{{ $sale->jumlah }}</span>

                                    <form action="{{ route('sales.increase', $sale->idSale) }}" method="POST">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow-sm">+</button>
                                    </form>
                                    
                                    <a href="{{ route('product.editt', $sale->idProduct) }}"
                                          class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-white px-1 py-1 rounded ml-2 shadow-sm">
                                           ✏️ <span class="ml-1"></span>
                                       </a>

                                    <form action="{{ route('sales.destroy', $sale->idSale) }}" method="POST">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded  shadow-sm">🗑</button>
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
            <div class="bg-white p-6 rounded-xl shadow-md space-y-6">
                @php
                    $subTotal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaJual);
                    $total = $subTotal;
                @endphp

                <div class="flex justify-between text-sm">
                    <label class="text-gray-600">Sub Total</label>
                    <p class="font-bold text-gray-800">Rp {{ number_format($subTotal, 0, ',', '.') }}</p>
                </div>

                <div>
                    <label class="text-sm text-gray-600">Barang Dibeli</label>
                    <ul class="text-sm space-y-1 mt-2">
                        @foreach ($sales as $sale)
                            <li class="flex justify-between text-gray-700">
                                <span>{{ $sale->product->namaBarang }} ({{ $sale->jumlah }}x)</span>
                                <span>Rp {{ number_format($sale->jumlah * $sale->product->hargaJual, 0, ',', '.') }}</span>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="flex justify-between items-center border-t pt-4">
                    <label class="text-sm text-gray-700">Total Bayar</label>
                    <p class="text-xl font-bold text-grey-600">Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>

                <form method="POST">
                    @csrf
                    <div class="space-y-4">
                        <div>
                            <label class="text-sm text-gray-600">Bayar</label>
                            <div class="flex items-center space-x-2">
                                <input type="number" name="bayar" id="bayar-input"
                                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-400 focus:ring focus:outline-none"
                                    oninput="updateKembalian()" />
                                <button type="submit" formaction="{{ route('sales.checkout') }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-md">
                                    Checkout
                                </button>
                            </div>
                            <p class="text-blue-500 text-xs mt-1 hover:underline cursor-pointer" onclick="setExact()">Uang Pas</p>
                        </div>

                        @if(session('success'))
                            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div>
                            <label class="text-sm text-gray-600">Kembalian</label>
                            <p id="kembalian-output" class="text-lg font-bold text-gray-700">
                                Rp. {{ (int)old('bayar', 0) <= 0 ? '0' : number_format(old('bayar') - $total, 0, ',', '.') }}
                            </p>
                        </div>

                        <input type="hidden" name="total" value="{{ $total }}">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function updateKembalian() {
            const bayarInput = document.getElementById('bayar-input');
            const kembalianOutput = document.getElementById('kembalian-output');
            const total = {{ $total }};
            const bayar = parseInt(bayarInput.value) || 0;
            const kembalian = Math.max(0, bayar - total);
            kembalianOutput.innerText = 'Rp. ' + new Intl.NumberFormat('id-ID').format(kembalian);
        }

        function setExact() {
            const bayarInput = document.getElementById('bayar-input');
            bayarInput.value = {{ $total }};
            updateKembalian();
        }

        document.addEventListener('DOMContentLoaded', () => {
            updateKembalian();
        });
    </script>
</x-app-layout>
