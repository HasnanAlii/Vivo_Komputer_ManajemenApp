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
            <!-- Tambah Customer Button -->
            <a href="{{ route('sales.add') }}" 
            class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                Tambah Customer
            </a>

            {{-- <div x-data="{ showTambahCustomer: false }"> --}}


           {{-- <button  @click="showTambahCustomer = true"
                    class="inline-flex items-center px-5 py-2 bg-blue-600 hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 text-white font-semibold rounded-lg shadow-md transition duration-200 ease-in-out"
                    >
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Tambah Customer
                    </button>


            {{-- modal di sini --}}
            {{-- <div x-show="showTambahCustomer" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50" x-transition>
            <div @click.away="showTambahCustomer = false" class="bg-white rounded-xl shadow-lg w-[400px] p-6">
                <h2 class="text-xl font-bold mb-4 text-blue-700">👤 Tambah Customer</h2>
                <form action="{{ route('sales.addcustomer') }}" method="POST">
                    @csrf

                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700 mb-1">Nama</label>
                        <input type="text" id="nama" name="nama" maxlength="50" placeholder="Nama Customer" 
                            class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <div class="mb-4">
                        <label for="alamat" class="block text-sm font-medium text-gray-700 mb-1">Alamat</label>
                        <textarea id="alamat" name="alamat" maxlength="255" placeholder="Alamat Customer" rows="3"
                            class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 resize-none"></textarea>
                    </div>

                    <div class="mb-4">
                        <label for="noTelp" class="block text-sm font-medium text-gray-700 mb-1">No. Telepon</label>
                        <input type="text" id="noTelp" name="noTelp" maxlength="255" placeholder="No. Telepon Customer" 
                            class="w-full rounded border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                    </div>

                    <div class="flex justify-end space-x-3">
                        <button type="button" @click="showTambahCustomer = false" class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-700">
                            Batal
                        </button>
                        <button type="submit" class="px-4 py-2 rounded bg-blue-600 hover:bg-blue-700 text-white font-semibold">
                            Simpan
                        </button>
                    </div>
                </form>
            </div>

            
        </div> --}}

        {{-- </div>  --}}

        </div>
    </x-slot>
    
    <div class="py-6">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-3 gap-6">
            
            <!-- Produk -->
            <div class="col-span-2 bg-white p-6 rounded-xl shadow-md">
                
               <div class="space-y-4 mb-6">
                <!-- Customer & Employee -->
                <div class="flex flex-col lg:flex-row gap-4">
                    <div class="flex-1">
                        <label for="select-customer" class="block text-sm font-semibold text-gray-700 mb-1">Pilih Pelanggan</label>
                        <select id="select-customer" class="w-full"></select>
                    </div>
                    <div class="flex-1">
                        <label for="select-employee" class="block text-sm font-semibold text-gray-700 mb-1">Pilih Kasir </label>
                        <select id="select-employee" class="w-full"></select>
                    </div>
                </div>

                <!-- Produk -->
                <div>
                    <label for="select-product" class="block text-sm font-semibold text-gray-700 mb-1">Cari & Tambah Produk</label>
                    <select id="select-product" class="w-full"></select>
                </div>
            </div>


                <table class="min-w-full divide-y divide-gray-200 mt-4">
                    <thead class="bg-gray-100">
                        <tr class="text-gray-700 text-sm">
                            <th class="px-4 py-2 text-left">Stok</th>
                            <th class="px-4 py-2 text-left">Nama Produk</th>
                            <th class="px-4 py-2 text-center">Harga</th>
                            <th class="px-4 py-2 text-center">Jumlah</th>
                            <th class="px-4 py-2 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100 text-sm">
                        @forelse ($sales as $sale)
                            <tr>
                                <td class="px-4 py-2 text-grey-600 text-center">
                                    {{ $sale->product->jumlah }}
                               </td>
                                <td class="px-4 py-2 font-medium">{{ $sale->product->namaBarang }}</td>
                                <td class="px-4 py-2 text-grey-600 text-center">
                                    Rp {{ number_format($sale->hargaTransaksi, 0, ',', '.') }}
                                </td>
                                <td class="px-4 py-2 text-center">{{ $sale->jumlah }}</td>
                          <td class="flex flex-wrap gap-2 w-52 items-left px-4 py-2">
                        {{-- Form Ubah Harga --}}
                        <form action="{{ route('sales.editPrice', $sale->idSale) }}" method="POST" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input 
                                type="text" 
                                name="hargaTransaksi" 
                                value="{{ $sale->hargaTransaksi }}" 
                                class="w-28 px-2 py-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 format-ribuann"
                                required
                            >
                            <button 
                                type="submit" 
                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded shadow-sm text-sm"
                            >
                                MarkUp
                            </button>
                          </form>
                           {{-- <form action="{{ route('sales.cashback', $sale->idSale) }}" method="POST" class="flex items-center gap-2">
                            @csrf @method('PATCH')
                            <input 
                                type="text" 
                                name="hargaTransaksi" 
                                value="{{ $sale->hargaTransaksi }}" 
                                class="w-28 px-2 py-1 border border-gray-300 rounded shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-400 format-ribuann"
                                required
                            >
                            <button 
                                type="submit" 
                                class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-1 rounded shadow-sm text-sm"
                            >
                                Cashback
                            </button>
                          </form> --}}
                               {{-- Tombol Kurangi Jumlah --}}
                        <form action="{{ route('sales.decrease', $sale->idSale) }}" method="POST">
                            @csrf @method('PATCH')
                            <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow-sm">-</button>
                        </form>

                        {{-- Jumlah Produk
                        <span class="font-semibold text-gray-800 ">{{ $sale->jumlah }}</span> --}}

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

                <!-- Display selected customer and employee info -->
                @if(isset($customer))
                    <div class="bg-blue-50 p-3 rounded">
                        <label class="text-sm text-blue-600 font-semibold">Customer Terpilih:</label>
                        <span class="text-sm text-blue-800">{{ $customer->nama }}</span>
                    </div>
                @endif

                @if(isset($employee))
                    <div class="bg-green-50 p-3 rounded">
                        <label class="text-sm text-green-600 font-semibold">Kasir:</label>
                        <span class="text-sm text-green-800">{{ $employee->nama }}</span>
                    </div>
                @endif

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

        {{-- Hidden: ID Employee jika ada --}}
        @if(isset($employee))
            <input type="hidden" name="idEmployee" value="{{ $employee->idEmployee }}">
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
             <div class="flex items-center">
                    <input type="checkbox" name="statuspembayaran" id="statuspembayaran" value="1"
                        {{ old('statuspembayaran') ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="statuspembayaran" class="ml-2 block text-sm text-gray-700">
                        Cashback
                    </label>
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


<script>
$(document).ready(function() {
    // Initialize employee select2
    $('#select-employee').select2({
        placeholder: 'Cari Kasir...',
        allowClear: true,
        width: '100%',
        ajax: {
            url: '{{ route("sales.employee") }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    page: params.page || 1
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 1,
        templateResult: formatResult,
        templateSelection: formatSelection
    });

    // Initialize customer select2
    $('#select-customer').select2({
        placeholder: 'Cari Pelanggan...',
        allowClear: true,
        width: '100%',
        ajax: {
            url: '{{ route("sales.customer") }}',
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    q: params.term,
                    page: params.page || 1
                };
            },
            processResults: function(data, params) {
                params.page = params.page || 1;
                return {
                    results: data.results,
                    pagination: {
                        more: (params.page * 10) < data.total_count
                    }
                };
            },
            cache: true
        },
        minimumInputLength: 1,
        templateResult: formatResult,
        templateSelection: formatSelection
    });

    // Shared format functions
    function formatResult(item) {
        if (item.loading) return item.text;
        
        var markup =  item.text ;
            
        if (item.additional_info) {
            markup += item.additional_info;
        }
        
        
        return markup;
    }

    function formatSelection(item) {
        return item.text || item.nama;
    }

    // Handle selection events for both dropdowns
    function handleSelection(element, paramName) {
        element.on('select2:select', function(e) {
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set(paramName, e.params.data.id);
            window.location.href = currentUrl.toString();
        });

        element.on('select2:unselect', function() {
            var currentUrl = new URL(window.location.href);
            currentUrl.searchParams.delete(paramName);
            window.location.href = currentUrl.toString();
        });
    }

    // Apply handlers
    handleSelection($('#select-employee'), 'employee');
    handleSelection($('#select-customer'), 'customer');

    // Set initial values if present
    @if(isset($employee))
        $('#select-employee').append(
            new Option('{{ $employee->nama }}', '{{ $employee->idEmployee }}', true, true)
        ).trigger('change');
    @endif

    @if(isset($customer))
        $('#select-customer').append(
            new Option('{{ $customer->nama }}', '{{ $customer->idCustomer }}', true, true)
        ).trigger('change');
    @endif

    // Add custom CSS
    $('<style>' +
      '.select2-result-item__title { font-weight: 500; }' +
      '.select2-result-item__info { margin-top: 2px; color: #6c757d; }' +
      '.select2-container--default .select2-selection--single { height: 38px; padding-top: 4px; }' +
      '</style>').appendTo('head');
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

<script>
  document.querySelectorAll('.format-ribuann').forEach(function(input) {
    input.addEventListener('input', function(e) {
      // Hapus semua titik dulu
      let value = e.target.value.replace(/\./g, '').replace(/[^0-9]/g, '');
      // Format angka dengan pemisah ribuan
      e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
    });
  });
</script>
</x-app-layout>
