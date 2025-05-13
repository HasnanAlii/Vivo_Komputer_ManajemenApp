<x-app-layout>
    {{-- <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot> --}}

    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="h-52  bg-blue-100 shadow-sm sm:rounded-lg">

                </div>
                <div class="p-6 text-gray-900 max-h-90 " >
                    <div class="grid grid-cols-3 gap-4 mx-40">
                      <!-- Left 2 columns (4 cards) -->
                      <div class="col-span-2 grid grid-cols-2 gap-4 ">
                        <!-- Inventory -->
                        <div class="bg-blue-200 p-4 rounded-xl ">
                          <h2 class="font-semibold text-2xl mb-2">Inventory</h2>
                          <p class="text-sm text-gray-700 mb-4">
                            Lorem ipsum dolor sit amet adipisicing elit.amet quisquam explicabo commodi ipsum.
                          </p>
                          <div class="flex justify-end">
                            <button onclick="window.location.href='{{ route('inventory.index') }}'" 
                            class="w-20 h-10 border-2 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                                <span class="text-xl">→</span>
                            </button>
                          </div>
                        </div>
                        <!-- Pembelian Produk -->
                        <div class="bg-blue-200 p-4 rounded-xl w-fit">
                          <h2 class="font-semibold text-2xl mb-2">Pembelian Produk</h2>
                          <p class="text-sm text-gray-700 mb-4">
                            Lorem ipsum dolor sit amet adipisicing elit.amet quisquam explicabo commodi ipsum.
                          </p>
                          <div class="flex justify-end">
                            <button onclick="window.location.href='{{ route('purchasing.index') }}'" 
                            class="w-20 h-10 border-2 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                                <span class="text-xl">→</span>
                            </button>
                            
                          </div>
                        </div>
                        <!-- Laporan Penjualan -->
                        <div class="bg-blue-200 p-4 rounded-xl">
                          <h2 class="font-semibold text-2xl mb-2">Laporan Penjualan</h2>
                          <p class="text-sm text-gray-700 mb-4">
                            Lorem ipsum dolor sit amet adipisicing elit.amet quisquam explicabo commodi ipsum.
                          </p>
                          <div class="flex justify-end">
                            <button onclick="window.location.href='{{ route('reports.index') }}'" 
                            class="w-20 h-10 border-2 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                                <span class="text-xl">→</span>
                            </button>
                            
                          </div>
                        </div>
                        <!-- Produk/Jasa Terlaris -->
                        <div class="bg-blue-200 p-4 rounded-xl">
                          <h2 class="font-semibold text-2xl mb-2">Servis</h2>
                          <p class="text-sm text-gray-700 mb-4">
                            Lorem ipsum dolor sit amet adipisicing elit.amet quisquam explicabo commodi ipsum.
                          </p>
                          <div class="flex justify-end">
                            <button onclick="window.location.href='{{ route('service.index') }}'" 
                            class="w-20 h-10 border-2 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                                <span class="text-xl">→</span>
                            </button>
                            
                          </div>
                        </div>
                      </div>
                  
                      <!-- Sidebar Kasir -->
                      <div class="bg-blue-200 p-4 rounded-xl flex flex-col justify-center">
                        <div>
                          <h2 class="font-semibold text-4xl mb-2">Kasir</h2>
                          <p class="text-sm text-gray-700">
                            Lorem ipsum dolor sit amet adipisicing elit. amet quisquam explicabo commodi ipsum.
                          </p>
                        </div>
                        <div class="mt-6 self-end">
                      
                          <button onclick="window.location.href='{{ route('sales.index') }}'" 
                                  class="w-20 h-10 border-2 bg-gray-200 rounded-full flex items-center justify-center hover:bg-gray-300 transition">
                              <span class="text-xl">→</span>
                          </button>

                        </div>
                      </div>
                    </div>
                  </div>
                  
            </div>
        </div>
    </div>
</x-app-layout>
