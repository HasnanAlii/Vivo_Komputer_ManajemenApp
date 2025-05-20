<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <button type="button" onclick="window.location='{{ route('dashboard') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                </button>
            {{ __('📊 Laporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mt-20">
                
                {{-- Laporan Sales --}}
                <a href="{{ route('reports.sales', ['jenis' => 'sales']) }}"
                   class="group block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-10 px-6 rounded-2xl text-center text-xl shadow-xl transform transition hover:-translate-y-1 hover:scale-105">
                    <div class="flex flex-col items-center justify-center">
                       <svg class="w-12 h-12 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2"
                          viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                          <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16 11V7a4 4 0 10-8 0v4M5 8h14l1 12a2 2 0 01-2 2H6a2 2 0 01-2-2l1-12z"/>
                      </svg>
                        Laporan Penjualan
                    </div>
                </a>

                {{-- Laporan Services --}}
                <a href="{{ route('reports.services', ['jenis' => 'service']) }}"
                   class="group block bg-green-600 hover:bg-green-700 text-white font-semibold py-10 px-6 rounded-2xl text-center text-xl shadow-xl transform transition hover:-translate-y-1 hover:scale-105">
                    <div class="flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2" 
                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                      <circle cx="12" cy="12" r="3" stroke-linecap="round" stroke-linejoin="round"/>
                      <path stroke-linecap="round" stroke-linejoin="round" d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 01-2.83 2.83l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09a1.65 1.65 0 00-1-1.51 1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06a1.65 1.65 0 00.33-1.82 1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09a1.65 1.65 0 001.51-1 1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06a1.65 1.65 0 001.82.33H9a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06a1.65 1.65 0 00-.33 1.82V9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/>
                    </svg>
                        Laporan Services
                    </div>
                </a>

                {{-- Laporan Purchasings --}}
                <a href="{{ route('reports.purchasings', ['jenis' => 'purchasings']) }}"
                   class="group block bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-10 px-6 rounded-2xl text-center text-xl shadow-xl transform transition hover:-translate-y-1 hover:scale-105">
                    <div class="flex flex-col items-center justify-center">
                        <svg class="w-12 h-12 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2"
                             viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.293 2.707A1 1 0 007.618 17H17m-10 0a1 1 0 102 0m6 0a1 1 0 102 0"/>
                        </svg>
                        Laporan Pembelian
                    </div>
                </a>
                {{-- Laporan Customers --}}
                    <a href="{{ route('reports.customer', ['jenis' => 'customers']) }}"
                    class="group block bg-purple-600 hover:bg-purple-700 text-white font-semibold py-10 px-6 rounded-2xl text-center text-xl shadow-xl transform transition hover:-translate-y-1 hover:scale-105">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M12 12a5 5 0 100-10 5 5 0 000 10z" />
                            </svg>
                            Laporan Pelanggan
                        </div>
                    </a>


            </div>
        </div>
    </div>
</x-app-layout>
