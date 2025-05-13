<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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


//     public function index(Request $request)
// {
//      $userId = auth()->id();




//     // Jika tidak ada transaksi aktif untuk user ini, buat transaksi baru
//     $activeSale = Sale::where('idUser', $userId)
//                       ->whereNull('idFinance')  // Pastikan transaksi belum selesai
//                       ->first();

//     if (!$activeSale) {
//         // Buat transaksi baru di tabel sales
//         $product = Product::first(); // Atau sesuaikan dengan produk yang default

//         // Membuat transaksi baru di sales
//         $newSale = Sale::create([
//             'nomorFaktur' => rand(10000000, 99999999),
//             'jumlah' => 0,
//             'totalHarga' => 0,
//             'keuntungan' => 0,
//             'tanggal' => now(),
//             'idUser' => $userId,
//             'idProduct' => $product ? $product->idProduct : null, // Jika ada produk
//         ]);
//     }





//     // Cari produk berdasarkan input search
//     if ($request->has('search') && !empty($request->search)) {
//         $product = Product::where('namaBarang', 'like', '%' . $request->search . '%')->first();

//         if ($product) {
//             // Cek apakah produk sudah ada di sales, jika ya tambahkan jumlahnya
//             $existingSale = Sale::where('idProduct', $product->idProduct)->first();

//             if ($existingSale) {
//                 $existingSale->jumlah += 1;
//                 $existingSale->totalHarga = $existingSale->jumlah * $product->hargaJual;
//                 $existingSale->keuntungan = $existingSale->totalHarga - ($existingSale->jumlah * $product->hargaBeli);
//                 $existingSale->save();
//             } else {
//                 // Tambah baru jika belum ada
//                 Sale::create([
//                     'nomorFaktur' => rand(10000000, 99999999),
//                     'jumlah' => 1,
//                     'totalHarga' => $product->hargaJual,
//                     'keuntungan' => $product->hargaJual - $product->hargaBeli,
//                     'tanggal' => now(),
//                     'idUser' => 1, // sesuaikan dengan user login, bisa pakai Auth::id()
//                     'idProduct' => $product->idProduct,
//                 ]);
//             }

//             return redirect()->route('sales.index');
//         }
//     }

//     // Tampilkan data sales dengan relasi produk
//     $sales = Sale::with('product')->get();

//     return view('sales.index', compact('sales'));
//     }
        


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
//     public function checkout(Request $request)
// {
//     $request->validate([
//         'bayar' => 'required|numeric|min:0',
//         'total' => 'required|numeric|min:0',
//     ]);

//     $sales = Sale::with('product')
//         ->whereNull('idFinance')
//         ->where('idUser', Auth::id())
//         ->get();

//     if ($sales->isEmpty()) {
//         return redirect()->route('sales.index')->with('error', 'Tidak ada item yang dibeli.');
//     }

//     $totalBayar = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaJual);
//     $totalModal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaBeli);
//     $totalKeuntungan = $totalBayar - $totalModal;
//     $bayar = $request->bayar;

//     if ($bayar < $totalBayar) {
//         return redirect()->route('sales.index')->with('error', 'Pembayaran kurang dari total.');
//     }

//     DB::beginTransaction();

//     try {
//         // Simpan ke tabel finance
//         $finance = new Finance();
//         $finance->danaMasuk = $totalBayar;
//         $finance->modal = $totalModal;
//         $finance->keuntungan = $totalKeuntungan;
//         $finance->totalDana = $totalBayar; // atau bisa danaMasuk - pengeluaran jika ada
//         $finance->tanggal = now()->toDateString();
//         $finance->save();

//         // Update semua sales dengan finance ID dan detail harga
//         foreach ($sales as $sale) {
//             $sale->idFinance = $finance->idFinance;
//             $sale->totalHarga = $sale->jumlah * $sale->product->hargaJual;
//             $sale->keuntungan = $sale->jumlah * ($sale->product->hargaJual - $sale->product->hargaBeli);
//             $sale->tanggal = now();
//             $sale->save();
//         }

//         DB::commit();

//         return redirect()->route('sales.index')->with('success', 'Transaksi berhasil. Dana dicatat ke keuangan.');
//     } catch (\Exception $e) {
//         DB::rollBack();
//         return redirect()->route('sales.index')->with('error', 'Gagal menyelesaikan transaksi: ' . $e->getMessage());
//     }
// }

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

    // Mendapatkan transaksi aktif untuk user ini
    $sales = Sale::with('product')
        ->whereNull('idFinance') // Belum ada idFinance
        ->where('idUser', Auth::id())
        ->get();

    if ($sales->isEmpty()) {
        return redirect()->route('sales.index')->with('error', 'Tidak ada item yang dibeli.');
    }

    // Hitung total bayar, modal, dan keuntungan
    $totalBayar = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaJual);
    $totalModal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaBeli);
    $totalKeuntungan = $totalBayar - $totalModal;
    $bayar = $request->bayar;

    if ($bayar < $totalBayar) {
        return redirect()->route('sales.index')->with('error', 'Pembayaran kurang dari total.');
    }

    DB::beginTransaction();

    try {
        // Simpan ke tabel finance
        $finance = new Finance();
        $finance->danaMasuk = $totalBayar;
        $finance->modal = $totalModal;
        $finance->keuntungan = $totalKeuntungan;
        $finance->totalDana = $totalBayar; // atau bisa danaMasuk - pengeluaran jika ada
        $finance->tanggal = now()->toDateString();
        $finance->save();

        // Update semua sales dengan finance ID dan detail harga
        foreach ($sales as $sale) {
            $sale->idFinance = $finance->idFinance;
            $sale->totalHarga = $sale->jumlah * $sale->product->hargaJual;
            $sale->keuntungan = $sale->jumlah * ($sale->product->hargaJual - $sale->product->hargaBeli);
            $sale->tanggal = now();
            $sale->save();
        }

        DB::commit();

        return redirect()->route('sales.index')->with('success', 'Transaksi berhasil. Dana dicatat ke keuangan.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('sales.index')->with('error', 'Gagal menyelesaikan transaksi: ' . $e->getMessage());
    }
}


    public function decrease($id)
    {
        $sale = Sale::findOrFail($id);

        if ($sale->jumlah > 1) {
            $sale->jumlah -= 1;
            $sale->save();
        } else {
            // Optional: hapus produk jika jumlah tinggal 1
            $sale->delete();
        }

        return redirect()->route('sales.index');
    }

}
