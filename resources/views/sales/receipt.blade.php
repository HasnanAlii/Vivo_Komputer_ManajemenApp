<x-app-layout>
    <div id="print-area" class="max-w-md mx-auto p-6 bg-white rounded-lg shadow-lg border">
        <div class="flex items-center justify-between border-b pb-4 mb-4">
            <img src="/assets/images/struk.png" alt="Vivo Komputer Logo" class="w-24 h-auto">
            <div>
                <h1 class="text-2xl font-bold text-gray-800">Vivo Komputer</h1>
                <p class="text-sm text-gray-600">Jl. Pasirgede Raya Bojongherang Cianjur</p>
                <p class="text-sm text-gray-600">Telp: 0812-3456-7890</p>
            </div>
          <div class="text-right">
    <p class="text-sm text-gray-600">Nomor Faktur :</p>
    <p class="text-lg font-bold text-gray-900">{{ $sales->first()->nomorFaktur ?? '-' }}</p>
</div>

        </div>

        <h2 class="text-lg font-semibold mb-4 text-center">Nota Pembelian</h2>

        <ul class="divide-y divide-gray-200 mb-6">
            @foreach ($sales as $sale)
                <li class="flex justify-between py-2">
                    <div>
                        <span class="font-medium text-gray-700">{{ $sale->product->namaBarang }}</span>
                        <span class="text-gray-500 text-sm ml-2">({{ $sale->jumlah }}x)</span>
                    </div>
                    <div class="font-semibold text-gray-900">
                        Rp {{ number_format($sale->jumlah * $sale->product->hargaJual, 0, ',', '.') }}
                    </div>
                </li>
            @endforeach
        </ul>

        <div class="border-t pt-4 space-y-2 text-right text-gray-700">
            <p class="flex justify-between font-semibold">
                <span>Total:</span>
                <span>Rp {{ number_format($total, 0, ',', '.') }}</span>
            </p>
            <p class="flex justify-between font-semibold">
                <span>Bayar:</span>
                <span>Rp {{ number_format($bayar, 0, ',', '.') }}</span>
            </p>
            <p class="flex justify-between font-bold text-gray-900 text-lg">
                <span>Kembalian:</span>
                <span>Rp {{ number_format($kembalian, 0, ',', '.') }}</span>
            </p>
        </div>
    </div>

    <div class="mt-6 text-center no-print flex justify-center gap-5">
        <button type="button" onclick="window.location='{{ route('sales.index') }}'"
            class="bg-gray-200 hover:bg-gray-300 text-gray-800 font-semibold px-5 py-2 rounded shadow transition">
            🔙 Kembali
        </button>

        <button onclick="window.print()"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded shadow">
            🖨️ Cetak Nota
        </button>
    </div>
</x-app-layout>

<style>
    @media print {
        body * {
            visibility: hidden !important;
        }

        #print-area,
        #print-area * {
            visibility: visible !important;
        }

        #print-area {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            margin: 0;
            padding: 1cm;
            width: 100%;
            background: white;
            box-shadow: none !important;
        }

        .no-print {
            display: none !important;
        }

        @page {
            size: A4 portrait;
            margin: 0;
        }

        html,
        body {
            margin: 0 !important;
            padding: 0 !important;
            height: 100%;
        }
    }
</style>
