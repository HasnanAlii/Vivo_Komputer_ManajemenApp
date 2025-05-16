<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Sale;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search') && !empty($request->search)) {
            $product = Product::where('namaBarang', 'like', '%' . $request->search . '%')->first();

            if ($product) {
                $existingSale = Sale::whereNull('idFinance')
                                    ->where('idProduct', $product->idProduct)
                                    ->first();

                if ($existingSale) {
                    $existingSale->jumlah += 1;
                    $existingSale->totalHarga = $existingSale->jumlah * $product->hargaJual;
                    $existingSale->keuntungan = $existingSale->jumlah * ($product->hargaJual - $product->hargaBeli);
                    $existingSale->save();
                } else {
                    Sale::create([
                        'nomorFaktur' => rand(10000000, 99999999),
                        'jumlah' => 1,
                        'totalHarga' => $product->hargaJual,
                        'keuntungan' => $product->hargaJual - $product->hargaBeli,
                        'tanggal' => now(),
                        'idProduct' => $product->idProduct,
                    ]);
                }

                return redirect()->route('sales.index');
            }
        }

        $sales = Sale::with('product')
                     ->whereNull('idFinance')
                     ->get();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        return view('sales.create', [
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'nomorFaktur' => 'required|integer',
            'jumlah' => 'required|integer',
            'totalHarga' => 'required|integer',
            'keuntungan' => 'required|integer',
            'tanggal' => 'required|date',
            'idProduct' => 'required|exists:products,idProduct',
        ]);

        Sale::create($request->all());
        return redirect()->route('sales.index');
    }

    public function edit($id)
    {
        return view('sales.edit', [
            'sale' => Sale::findOrFail($id),
            'products' => Product::all(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $sale = Sale::findOrFail($id);
        $sale->update($request->all());
        return redirect()->route('sales.index');
    }

    public function destroy($id)
    {
        Sale::destroy($id);
        return redirect()->route('sales.index');
    }

    public function increase($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->jumlah += 1;
        $sale->totalHarga = $sale->jumlah * $sale->product->hargaJual;
        $sale->keuntungan = $sale->jumlah * ($sale->product->hargaJual - $sale->product->hargaBeli);
        $sale->save();

        return redirect()->route('sales.index');
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'bayar' => 'required|numeric|min:0',
            'total' => 'required|numeric|min:0',
        ]);

        $sales = Sale::with('product')
            ->whereNull('idFinance')
            ->get();

        if ($sales->isEmpty()) {
            return redirect()->route('sales.index')->with('error', 'Tidak ada item yang dibeli.');
        }

        $totalBayar = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaJual);
        $totalModal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaBeli);
        $totalKeuntungan = $totalBayar - $totalModal;
        $bayar = $request->bayar;

        if ($bayar < $totalBayar) {
            return redirect()->route('sales.index')->with('error', 'Pembayaran kurang dari total.');
        }

        DB::beginTransaction();

        try {
            $finance = new Finance();
            $finance->dana = 'masuk';
            $finance->dana = $totalBayar;
            $finance->modal = $totalModal;
            $finance->keuntungan = $totalKeuntungan;
            $finance->totalDana = $totalBayar;
            $finance->tanggal = now()->toDateString();
            $finance->keterangan = 'penjualan produk';
            $finance->save();

            foreach ($sales as $sale) {
                $product = $sale->product;

                if ($product->jumlah < $sale->jumlah) {
                    throw new \Exception("Stok barang '{$product->namaBarang}' tidak mencukupi.");
                }

                $product->jumlah -= $sale->jumlah;
                $product->save();

                $sale->idFinance = $finance->idFinance;
                $sale->totalHarga = $sale->jumlah * $product->hargaJual;
                $sale->keuntungan = $sale->jumlah * ($product->hargaJual - $product->hargaBeli);
                $sale->tanggal = now();
                $sale->save();
            }

            DB::commit();
            session()->flash('bayar', $bayar);

            return redirect()->route('sales.print', ['id' => $finance->idFinance]);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('sales.index')->with('error', 'Gagal menyelesaikan transaksi: ' . $e->getMessage());
        }
    }

    public function printReceipt($id)
    {
        $sales = Sale::with(['product', 'finance'])
                    ->where('idFinance', $id)
                    ->get();

        if ($sales->isEmpty()) {
            return redirect()->route('sales.index')->with('error', 'Transaksi tidak ditemukan.');
        }

        $total = $sales->sum('totalHarga');
        $modal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaBeli);
        $bayar = session('bayar') ?? $sales->first()->finance->dana ?? $total;
        $kembalian = $bayar - $total;

        return view('sales.receipt', compact('sales', 'total', 'bayar', 'kembalian'));
    }
}