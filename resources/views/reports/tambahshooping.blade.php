<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center space-x-4">
            <button type="button" onclick="window.location='{{ route('reports.shopping') }}'"
                class="inline-flex items-center px-4 py-2 bg-gray-100 hover:bg-gray-200 text-gray-800 font-medium rounded-lg shadow transition duration-200">
              🔙
            </button>
            <h2 class="text-2xl font-bold text-gray-800">
                Tambah Data Shopping
            </h2>
        </div>
    </x-slot>

    <div class="py-10">
        <div class="max-w-xl mx-auto bg-white rounded-xl shadow-lg p-8 space-y-6">
            <form action="{{ route('reports.store') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="sumber" class="block text-sm font-medium text-gray-700">Sumber</label>
                    <input type="text" name="sumber" id="sumber" value="{{ old('sumber') }}"
                        class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('sumber')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="jumlah" class="block text-sm font-medium text-gray-700">Jumlah</label>
                    <input type="text" name="jumlah" id="jumlah" value="{{ old('jumlah') }}"
                        class="format-ribuan mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('jumlah')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center">
                    <input type="checkbox" name="statuspembayaran" id="statuspembayaran" value="1"
                        {{ old('statuspembayaran') ? 'checked' : '' }}
                        class="h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                    <label for="statuspembayaran" class="ml-2 block text-sm text-gray-700">
                        Status Pembayaran Lunas
                    </label>
                </div>
                @error('statuspembayaran')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror

                <div>
                    <label for="totalbelanja" class="block text-sm font-medium text-gray-700">Total Belanja (Rp)</label>
                    <input type="text" name="totalbelanja" id="totalbelanja" value="{{ old('totalbelanja') }}"
                        class="format-ribuan mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                    @error('totalbelanja')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-4 text-right">
                    <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-semibold rounded-lg shadow-md transition duration-200">
                        💾 Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.querySelectorAll('.format-ribuan').forEach(function (input) {
            input.addEventListener('input', function (e) {
                let value = e.target.value.replace(/\./g, '').replace(/[^0-9]/g, '');
                e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            });
        });
    </script>
</x-app-layout>
