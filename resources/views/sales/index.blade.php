<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-bold text-2xl text-gray-800 flex items-center gap-2">
                 <button type="button" onclick="window.location='{{ route('dashboard') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                </button>
                🛒 <span>Halaman Kasir</span>
            </h2>
            {{-- <form action="{{ route('sales.index') }}" method="GET" class="flex items-center space-x-2">
                <input type="text" name="search" placeholder="Cari Produk..." value="{{ request('search') }}"
                    class="pl-3 pr-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-300">
            </form> --}}
            
        </div>
    </x-slot>
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Produk -->
            <div class="col-span-2 bg-white p-6 rounded-xl shadow-md">
                
                <select id="select-product" style="width: 350px;" ></select>
                <select id="select-customer" style="width: 350px"></select>
      

                

 


                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead class="bg-gray-100">
                        <tr class="text-gray-700 text-sm">
                            <th class="px-4 py-2 text-left">No</th>
                            <th class="px-4 py-2 text-left">Nama Produk</th>
                            <th class="px-4 py-2 text-center">Harga</th>
                            {{-- <th class="px-4 py-2 text-center">Stok Barang</th> --}}
                            <th class="px-4 py-2 text-center">Jumlah</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($sales as $sale)
                            <tr>
                                <td class="px-4 py-2">{{ $loop->iteration }}</td>
                                <td class="px-4 py-2 font-medium">{{ $sale->product->namaBarang }}</td>
                                <td class="px-4 py-2 text-grey-600 text-center">
                                    Rp {{ number_format($sale->hargaTransaksi, 0, ',', '.') }}
                                </td>
                                 {{-- <td class="px-4 py-2 text-grey-600 text-center">
                                                       {{ $sale->product->jumlah }}
                                </td> --}}

                                {{-- <td class="px-4 py-2 text-grey-600 text-center" >Rp {{ number_format($sale->product->hargaJual, 0, ',', '.') }}</td> --}}
                                <td class="px-4 py-2 text-center">{{ $sale->jumlah }}</td>
                          <td class="flex flex-wrap gap-2 items-center px-4 py-2">
                        {{-- Tombol Kurangi Jumlah --}}
                        <form action="{{ route('sales.decrease', $sale->idSale) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow-sm">-</button>
                        </form>

                        {{-- Jumlah Produk --}}

                        <span class="font-semibold text-gray-800">{{ $sale->jumlah }}</span>

                        {{-- Tombol Tambah Jumlah --}}
                        <form action="{{ route('sales.increase', $sale->idSale) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow-sm">+</button>
                        </form>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('sales.destroy', $sale->idSale) }}" method="POST">
                            @csrf @method('DELETE')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded shadow-sm">🗑</button>
                        </form>

                        {{-- Form Ubah Harga --}}
                        <form action="{{ route('sales.editPrice', $sale->idSale) }}" method="POST" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input 
                                type="number" 
                                name="hargaTransaksi" 
                                value="{{ $sale->hargaTransaksi }}" 
                                class="w-40 px-2 py-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                                required
                            >
                            <button 
                                type="submit" 
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded shadow-sm text-sm"
                            >
                                Ubah
                            </button>
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
                    $subTotal = $sales->sum(fn($s) => $s->jumlah * $s->hargaTransaksi);
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
                                <span>Rp {{ number_format($sale->jumlah * $sale->hargaTransaksi, 0, ',', '.') }}</span>
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
        {{-- Hidden: ID Customer jika ada --}}
        @if(isset($customer))
            <input type="hidden" name="idCustomer" value="{{ $customer->idCustomer }}">
        @endif

        {{-- Bayar --}}
        <div>
            <label class="text-sm text-gray-600">Bayar</label>
            <div class="flex items-center space-x-2">
                <input type="text" name="bayar" id="bayar-input"
                    class="w-full px-4 py-2 border border-gray-300 rounded-md focus:ring-blue-400 focus:ring focus:outline-none format-ribuan"
                    value="{{ old('bayar') }}"
                    oninput="updateKembalian()" />

                <button type="submit" formaction="{{ route('sales.checkout') }}"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded shadow-md">
                    Checkout
                </button>
            </div>
            <p class="text-blue-500 text-xs mt-1 hover:underline cursor-pointer" onclick="setExact()">Uang Pas</p>
        </div>

        {{-- Flash Message --}}
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

        {{-- Kembalian --}}
        <div>
            <label class="text-sm text-gray-600">Kembalian</label>
            <p id="kembalian-output" class="text-lg font-bold text-gray-700">
                Rp. {{ old('bayar') ? number_format(old('bayar') - $total, 0, ',', '.') : '0' }}
            </p>
        </div>

        {{-- Hidden: Total --}}
        <input type="hidden" name="total" value="{{ $total }}">
    </div>
</form>


            </div>
        </div>
    </div>

    {{-- <script>
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
    </script> --}}

<script>
$(document).ready(function() {
    $('#select-customer').select2({
        placeholder: 'Cari customer...',
        ajax: {
            url: '{{ route('sales.customer') }}', // Buat route ini di controller
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term
                };
            },
            processResults: function(data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        minimumInputLength: 1,
    });

    // Event saat customer dipilih
    $('#select-customer').on('select2:select', function(e) {
        var customerId = e.params.data.id;

        // Redirect ke halaman sales dengan customer yang dipilih
        window.location.href = '{{ route('sales.index') }}' + '?customer=' + customerId;
    });
});
</script>
<script>
$(document).ready(function() {
    $('#select-product').select2({
        placeholder: 'Cari produk...',
        ajax: {
            url: '{{ route('sales.search') }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return { q: params.term }; // term dari inputan user
            },
            processResults: function(data) {
                return {
                    results: data.results
                };
            },
            cache: true
        },
        minimumInputLength: 1,
    });

    // Event saat produk dipilih
    $('#select-product').on('select2:select', function(e) {
        var productId = e.params.data.id;

        // Kirim ajax untuk tambah produk ke penjualan
        $.ajax({
            url: '{{ route('sales.index') }}',  // route ke index yang sudah kamu punya
            type: 'GET',
            data: { search: productId },
            success: function(response) {
                // Refresh halaman atau update tabel penjualan secara dinamis
                location.reload(); // paling simpel reload halaman biar data sales update
            },
            error: function() {
                alert('Gagal menambahkan produk.');
            }
        });

        // Reset select agar bisa tambah produk lain lagi
        $('#select-product').val(null).trigger('change');
    });
});
</script>
<script>
    // Format input angka menjadi format ribuan Indonesia
    function formatRibuanAngka(value) {
        return value.replace(/\./g, '').replace(/[^0-9]/g, '')
                    .replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    }

    // Ambil nilai angka numerik dari input bertipe string ribuan (misalnya: "1.000.000" -> 1000000)
    function parseRupiah(value) {
        return parseInt(value.replace(/\./g, '')) || 0;
    }

    // Update tampilan kembalian secara real-time
    function updateKembalian() {
        const bayarInput = document.getElementById('bayar-input');
        const kembalianOutput = document.getElementById('kembalian-output');
        const total = {{ $total }}; // Total dari server (angka tanpa titik)

        const bayar = parseRupiah(bayarInput.value);
        const kembalian = Math.max(0, bayar - total);
        
        kembalianOutput.innerText = 'Rp. ' + new Intl.NumberFormat('id-ID').format(kembalian);
    }

    // Tombol "Uang Pas"
    function setExact() {
        const bayarInput = document.getElementById('bayar-input');
        bayarInput.value = formatRibuanAngka(String({{ $total }}));
        updateKembalian();
    }

    // Saat dokumen dimuat
    document.addEventListener('DOMContentLoaded', () => {
        // Format ribuan otomatis pada semua input yang diberi class .format-ribuan
        document.querySelectorAll('.format-ribuan').forEach(function(input) {
            input.addEventListener('input', function(e) {
                e.target.value = formatRibuanAngka(e.target.value);
                if (e.target.id === 'bayar-input') {
                    updateKembalian();
                }
            });
        });

        updateKembalian();
    });
</script>


</x-app-layout>
