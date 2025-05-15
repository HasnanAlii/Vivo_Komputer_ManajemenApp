<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class SaleController extends Controller
{
   public function index(Request $request)
{
    $userId = auth()->id();

    // Jika ada pencarian produk
    if ($request->has('search') && !empty($request->search)) {
        $product = Product::where('namaBarang', 'like', '%' . $request->search . '%')->first();

        if ($product) {
            // Cari apakah produk ini sudah ada di transaksi aktif user
            $existingSale = Sale::where('idUser', $userId)
                                ->whereNull('idFinance')
                                ->where('idProduct', $product->idProduct)
                                ->first();

            if ($existingSale) {
                // Update jumlah dan harga
                $existingSale->jumlah += 1;
                $existingSale->totalHarga = $existingSale->jumlah * $product->hargaJual;
                $existingSale->keuntungan = $existingSale->jumlah * ($product->hargaJual - $product->hargaBeli);
                $existingSale->save();
            } else {
                // Tambah produk baru ke transaksi aktif
                Sale::create([
                    'nomorFaktur' => rand(10000000, 99999999),
                    'jumlah' => 1,
                    'totalHarga' => $product->hargaJual,
                    'keuntungan' => $product->hargaJual - $product->hargaBeli,
                    'tanggal' => now(),
                    'idUser' => $userId,
                    'idProduct' => $product->idProduct,
                ]);
            }

            return redirect()->route('sales.index');
        }
    }

    // Ambil semua item transaksi aktif user (jika ada)
    $sales = Sale::with('product')
                 ->where('idUser', $userId)
                 ->whereNull('idFinance')
                 ->get();

    return view('sales.index', compact('sales'));
}



    public function create() {
        return view('sales.create', [
            'products' => Product::all(),
            'users' => User::all()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nomorFaktur' => 'required|integer',
            'jumlah' => 'required|integer',
            'totalHarga' => 'required|integer',
            'keuntungan' => 'required|integer',
            'tanggal' => 'required|date',
            'idUser' => 'required|exists:users,idUser',
            'idProduct' => 'required|exists:products,idProduct',
        ]);

        Sale::create($request->all());
        return redirect()->route('sales.index');
    }

    public function edit($id) {
        return view('sales.edit', [
            'sale' => Sale::findOrFail($id),
            'products' => Product::all(),
            'users' => User::all()
        ]);
    }

    public function update(Request $request, $id) {
        $sale = Sale::findOrFail($id);
        $sale->update($request->all());
        return redirect()->route('sales.index');
    }

    public function destroy($id) {
        Sale::destroy($id);
        return redirect()->route('sales.index');
    }


    public function increase($id)
    {
        $sale = Sale::findOrFail($id);
        $sale->jumlah += 1;
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
        ->where('idUser', Auth::id())
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
        $finance->danaMasuk = $totalBayar;
        $finance->modal = $totalModal;
        $finance->keuntungan = $totalKeuntungan;
        $finance->totalDana = $totalBayar;
        $finance->tanggal = now()->toDateString();
        $finance->save();

        foreach ($sales as $sale) {
            $product = $sale->product;

            // Kurangi stok barang
            if ($product->jumlah < $sale->jumlah) {
                throw new \Exception("Stok barang '{$product->namaBarang}' tidak mencukupi.");
            }

            $product->jumlah -= $sale->jumlah;
            $product->save();

            // Simpan data penjualan
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


public function printReceipt($id) {
    $sales = Sale::with(['product', 'finance'])
                ->where('idFinance', $id)
                ->get();
    
    if ($sales->isEmpty()) {
        return redirect()->route('sales.index')->with('error', 'Transaksi tidak ditemukan.');
    }
    
    $total = $sales->sum('totalHarga');
    $modal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaBeli);
    
    // Get payment amount from session if available, otherwise from finance record
    $bayar = session('bayar') ?? $sales->first()->finance->danaMasuk ?? $total;
    $kembalian = $bayar - $total;
    
    // $pdf = Pdf::loadView('sales.receipt', compact('sales', 'total', 'bayar', 'kembalian'));
    // return $pdf->stream('nota-penjualan.pdf');
    
    return view('sales.receipt', compact('sales', 'total', 'bayar', 'kembalian'));
}






}
