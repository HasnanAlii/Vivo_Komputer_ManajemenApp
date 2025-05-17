<x-app-layout>
    <div class="py-2">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Header Banner -->
               <div class="relative h-44 rounded-t-lg flex items-center justify-center overflow-hidden bg-gradient-to-r from-blue-200 to-blue-100">
                    <!-- Background image kecil di tengah -->
                    <div class="absolute inset-0 flex items-center  pointer-events-none">
                        <img src="{{ asset('assets/images/vivologo.png') }}" alt="Logo" class="h-28 ml-20 w-auto opacity-60" />
                    </div>

                    <!-- Konten teks di atas -->
                    <h1 class="relative text-4xl font-bold text-blue-800">Selamat Datang di Dashboard</h1>
                     <div class="absolute inset-0 flex items-center justify-end pointer-events-none">
                        <img src="{{ asset('assets/images/vivologo.png') }}" alt="Logo" class="h-28 mr-20 w-auto opacity-60" />
                    </div>
                </div>


                <!-- Konten Grid -->
                <div class="p-6 text-gray-900">
                    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">

                        <!-- Kolom Kiri (4 Kartu) -->
                        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Kartu 1: Inventory -->
                            <x-dashboard.card title="Stok Barang" route="{{ route('product.index') }}" icon="archive-box" />

                            <!-- Kartu 2: Pembelian Produk -->
                            <x-dashboard.card title="Pembelian Produk" route="{{ route('purchasing.create') }}" icon="shopping-cart" />

                            <!-- Kartu 3: Laporan Penjualan -->
                            <x-dashboard.card title="Laporan" route="{{ route('reports.index') }}" icon="document-text" />

                            <!-- Kartu 4: Keuangan -->
                            <x-dashboard.card title="Keuangan" route="{{ route('finances.index') }}" icon="currency-dollar" />
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="lg:col-span-2 grid grid-cols-1 sm:grid-cols-2 gap-6">
                            <!-- Servis -->
                            <x-dashboard.card title="Servis" route="{{ route('service.index') }}" icon="wrench-screwdriver" />

                            <!-- Kasir -->
                            <x-dashboard.card title="Kasir" route="{{ route('sales.index') }}" icon="credit-card" />
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
