<x-app-layout>
   <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight flex items-center gap-2">
             <button type="button" onclick="window.location='{{ route('dashboard') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                </button>

          📦 {{ __('Halaman Stok Barang') }}
        </h2>

   </x-slot>

   <div class="py-4">
       <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
           <div class="bg-white shadow-lg sm:rounded-lg p-6">
               <div class="flex justify-end items-center mb-6">
                   <form action="{{ route('product.import') }}" method="POST" enctype="multipart/form-data" class="flex items-center space-x-3 bg-gray-50 p-1 rounded-lg shadow-sm border border-dashed border-gray-300 hover:border-green-500 transition duration-200">
                    @csrf
                    <label for="excel-upload" class="flex items-center space-x-2 cursor-pointer text-sm text-gray-600 hover:text-green-600 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        <span>Pilih File Excel</span>
                    </label>
                    <input id="excel-upload" type="file" name="file" accept=".xlsx,.xls" class="hidden" required>
                    
                    <button type="submit" class="bg-green-500 hover:bg-green-600 text-white font-medium text-sm px-4 py-2 rounded shadow-sm transition duration-200">
                        Import
                    </button>
                </form>
                <a href="{{ route('product.create') }}"
                   class="ml-4 inline-flex items-center bg-blue-500 hover:bg-blue-700 text-white px-4 py-2 rounded shadow transition">
                    ➕ <span class="ml-2">Tambah Produk</span>
                </a>

               </div>

               @if(session('success'))
                   <div class="mb-4 px-4 py-2 bg-green-100 text-green-800 rounded">
                       {{ session('success') }}
                   </div>
               @endif

               <div class="overflow-x-auto">
                
                   <table class="min-w-full text-left border border-gray-200 rounded overflow-hidden">
                       <thead>
                           <tr class="bg-blue-100 text-blue-800">
                               <th class="px-4 py-2 text-center">No</th>
                               <th class="px-4 py-2">Nama Produk</th>
                               <th class="px-4 py-2 ">Kategori</th>
                               <th class="px-4 py-2 text-center">Kode</th>
                               <th class="px-4 py-2 text-center">Stok</th>
                               <th class="px-4 py-2 ">Harga</th>
                               <th class="px-4 py-2 text-center">Aksi</th>
                           </tr>
                       </thead>
                       <tbody>
                           @forelse($products as $i => $product)
                               <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} border-t hover:bg-gray-100">
                                   <td class="px-4 py-2 text-center">{{ $products->firstItem() + $i }}</td>
                                   <td class="px-4 py-2 font-medium">{{ $product->namaBarang }}</td>
                                   <td class="px-4 py-2">
                                        {{ $product->category->kodeKategori ?? 'Kategori Tidak Ditemukan' }}
                                    </td>
                                    <td class="px-4 py-2">
                                        {{ $product->category->namaKategori ?? 'Kategori Tidak Ditemukan' }}
                                    </td>

                                   <td class="px-4 py-2 text-center">{{ $product->jumlah }}</td>
                                   <td class="px-4 py-2 ">Rp {{ number_format($product->hargaJual) }}</td>
                                   <td class="px-4 py-2 text-center space-x-2">
                                       <a href="{{ route('product.edit', $product->idProduct) }}"
                                          class="inline-flex items-center bg-yellow-400 hover:bg-yellow-500 text-white px-3 py-1 rounded shadow transition">
                                           ✏️ <span class="ml-1"></span>
                                       </a>
                                       <form action="{{ route('product.destroy', $product->idProduct) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                           @csrf
                                           @method('DELETE')
                                           <button type="submit"
                                                   class="inline-flex items-center bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded shadow transition">
                                               🗑️ <span class="ml-1"></span>
                                           </button>
                                       </form>
                                   </td>
                               </tr>
                           @empty
                               <tr>
                                   <td colspan="7" class="px-4 py-4 text-center text-gray-500">Tidak ada produk tersedia.</td>
                               </tr>
                           @endforelse
                       </tbody>
                   </table>
               </div>

               <div class="mt-4 ">
              {{ $products->links('vendor.pagination.custom') }}

               </div>
           </div>
       </div>
   </div>
</x-app-layout>
