<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center gap-2">
            ➕📦 {{ __('Tambah Produk') }}
        </h2>
    </x-slot>

   <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded-xl shadow-md">
                 
   
          
                 <h2 class="text-3xl font-bold mb-6 text-blue-700">Tambah Produk</h2>

                @if ($errors->any())
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('product.store') }}" method="POST">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Nama Barang</label>
                            <input type="text" name="namaBarang" value="{{ old('namaBarang') }}"
                                class="w-full border border-gray-300 rounded-md px-4 py-2" required>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Jumlah</label>
                            <input type="text" name="jumlah" value="{{ old('jumlah') }}"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 format-ribuan" required>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Harga Beli</label>
                            <input type="text" name="hargaBeli" value="{{ old('hargaBeli') }}"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 format-ribuan" required>
                        </div>

                        <div>
                            <label class="block font-medium text-gray-700 mb-1">Harga Jual</label>
                            <input type="text" name="hargaJual" value="{{ old('hargaJual') }}"
                                class="w-full border border-gray-300 rounded-md px-4 py-2 format-ribuan" required>
                        </div>

                        <div class="md:col-span-2">
                            <label class="block font-medium text-gray-700 mb-1">Kategori</label>
                            <select name="idCategory" class="w-full border border-gray-300 rounded-md px-4 py-2" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->idCategory }}" {{ old('idCategory') == $category->idCategory ? 'selected' : '' }}>
                                        {{ $category->namaKategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    
                    <div class="mt-8 flex justify-end gap-3">
                        <button type="button" onclick="window.location='{{ route('product.index') }}'"
                            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                            🔙 Batal
                        </button>

                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded shadow transition">
                            💾 Simpan
                        </button>
                    </div>
                </form>
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
