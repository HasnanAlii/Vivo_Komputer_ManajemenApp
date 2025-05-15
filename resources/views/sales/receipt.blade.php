<x-app-layout>
   <div id="print-area" class="max-w-md mx-auto p-6 bg-white rounded shadow">
        <h2 class="text-lg font-semibold mb-4 text-center">Nota Pembelian</h2>
        <ul class="">
            @foreach ($sales as $sale)
                <li class="flex justify-between py-1">
                    <span>{{ $sale->product->namaBarang }} ({{ $sale->jumlah }}x)</span>
                    <span>Rp {{ number_format($sale->jumlah * $sale->product->hargaJual, 0, ',', '.') }}</span>
                </li>
            @endforeach
        </ul>

        <div class="mt-4 space-y-1 text-right ">
            <hr>
            <p>Total: <strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></p>
            <p>Bayar: <strong>Rp {{ number_format($bayar, 0, ',', '.') }}</strong></p>
            <p>Kembalian: <strong class="text-grey-600">Rp {{ number_format($kembalian, 0, ',', '.') }}</strong></p>
        </div>
    </div>

    <div class="mt-6 text-center no-print">
        <a href="{{ route('sales.index') }}" class="text-blue-500 underline">← Kembali ke Kasir</a>
        <br>
        <button onclick="window.print()" 
        class="bg-blue-600 hover:bg-blue-700 text-white mt-4 px-4 py-2 rounded">
        🖨️ Cetak Nota
        </button>
    </div>
</x-app-layout>

<style>
@media print {
    body * {
        visibility: hidden !important;
    }

    #print-area, #print-area * {
        visibility: visible !important;
    }

    #print-area {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        margin: 0;
        padding: 0.5cm;
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

    html, body {
        margin: 0 !important;
        padding: 0 !important;
        height: 100%;
    }
}
</style>
