<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
            <button type="button" onclick="window.location='{{ route('dashboard') }}'"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
                    🔙
                </button>
            {{ __('Tambah Pembelian') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6 mt-20">
                
                {{-- Laporan Sales --}}
                <a href="{{ route('purchasing.create', ['jenis' => 'sales']) }}"
                   class="group block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-10 px-6 rounded-2xl text-center text-xl shadow-xl transform transition hover:-translate-y-1 hover:scale-105">
                    <div class="flex flex-col items-center justify-center">
                     <svg class="w-12 h-12 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2"
                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M12 12a5 5 0 100-10 5 5 0 000 10z" />
                            </svg>  
                            Pelanggan Baru
                        </div>
                    </a>
                    <a href="{{ route('purchasing.createe', ['jenis' => 'customers']) }}"
                        class="group block bg-blue-800 hover:bg-grey-700 text-white font-semibold py-10 px-6 rounded-2xl text-center text-xl shadow-xl transform transition hover:-translate-y-1 hover:scale-105">
                        <div class="flex flex-col items-center justify-center">
                            <svg class="w-12 h-12 mb-4 group-hover:scale-110 transition" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round"
                            d="M5.121 17.804A7 7 0 0112 15a7 7 0 016.879 2.804M12 12a5 5 0 100-10 5 5 0 000 10z" />
                        </svg>
                        Pelanggan Lama
                        </div>
                    </a>


            </div>
        </div>
    </div>
</x-app-layout>
