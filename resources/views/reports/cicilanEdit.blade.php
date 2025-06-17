<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            <button type="button" onclick="window.location='{{ route('reports.customers') }}'"
                class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-4 py-2 rounded shadow transition">
                🔙
            </button>
            Edit Cicilan
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-md mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 rounded shadow">
                <form action="{{ route('reports.update', $customer->idCustomer) }}" method="POST" >
                    @csrf

                    <div class="mb-4">
                        <label for="nama" class="block text-sm font-medium text-gray-700">Nama Customer</label>
                        <input type="text" value="{{ $customer->nama }}" class="w-full px-3 py-2 border rounded bg-gray-100" disabled>
                    </div>

                    <div class="mb-4">
                        <label for="cicilan" class="block text-sm font-medium text-gray-700">Jumlah Bayar</label>
                        <input type="text" 
                            name="cicilan" 
                            id="cicilan" 
                            class="w-full px-3 py-2 border rounded focus:ring focus:ring-green-300 format-ribuan" 
                            placeholder="Masukkan jumlah bayar" 
                            autocomplete="off">
                    </div>

                    <div class="flex justify-center">
                        <button type="submit"
                            class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded shadow">
                            💳 Bayar & Cetak
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
      document.querySelectorAll('.format-ribuan').forEach(function(input) {
        input.addEventListener('input', function(e) {
          let value = e.target.value.replace(/\./g, '').replace(/[^0-9]/g, '');
          e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        });
      });
    </script>
</x-app-layout>
