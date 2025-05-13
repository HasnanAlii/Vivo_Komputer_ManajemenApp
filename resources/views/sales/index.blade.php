<x-app-layout>
   <x-slot name="header">
      <div class="flex items-center justify-between">
          <h2 class="font-semibold text-xl text-gray-800 leading-tight">
              {{ __('Penjualan Produk') }}
          </h2>
  
          <!-- Kotak Pencarian -->
          <form action="{{ route('sales.index') }}" method="GET" class="flex items-center space-x-2">
              <div class="relative">
                  <input type="text" name="search" placeholder="Cari Produk" value="{{ request('search') }}"
                      class="pl-10 pr-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring focus:border-blue-300">
                  <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                      <!-- Heroicon: Magnifying Glass -->
                      <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none"
                          viewBox="0 0 24 24" stroke="currentColor">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                              d="M21 21l-4.35-4.35M11 18a7 7 0 100-14 7 7 0 000 14z" />
                      </svg>
                  </div>
              </div>
          </form>
      </div>
  </x-slot>
  

    
</x-app-layout>
