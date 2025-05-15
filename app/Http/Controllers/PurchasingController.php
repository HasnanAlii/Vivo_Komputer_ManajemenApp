<?php

namespace App\Http\Controllers;

use App\Models\Purchasing;
use App\Models\User;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Finance;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PurchasingController extends Controller
{
    public function index()
    {
        $purchasings = Purchasing::with(['user', 'customer', 'product'])->get();
        return view('purchasings.index', compact('purchasings'));
    }


    public function create()
    {
        return view('purchasings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'noTelp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'namaBarang' => 'required|string|max:255',
            'kategori' => 'nullable|string|max:100',
            'kodeBarang' => 'nullable|string|max:100',
            'jumlah' => 'required|integer|min:1',
            'hargaBeli' => 'required|numeric|min:0',
            'hargaJual' => 'required|numeric|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Simpan customer
            $customer = Customer::create([
                'nama' => $request->nama,
                'noTelp' => $request->noTelp,
                'alamat' => $request->alamat,
            ]);

            // Cek produk
            $product = Product::where('namaBarang', $request->namaBarang)
                ->orWhere('kodeBarang', $request->kodeBarang)
                ->first();

            if (!$product) {
                $product = Product::create([
                    'namaBarang' => $request->namaBarang,
                    'kategori' => $request->kategori,
                    'kodeBarang' => $request->kodeBarang,
                    'jumlah' => $request->jumlah,
                    'hargaBeli' => $request->hargaBeli,
                    'hargaJual' => $request->hargaBeli * 1.2,
                ]);
            } else {
                $product->jumlah += $request->jumlah;
                $product->hargaBeli = $request->hargaBeli; // atau buat logika rata-rata
                $product->save();
            }

            // Simpan pembelian
            $total = $request->jumlah * $request->hargaBeli;
            $keuntungan = ($request-> hargaJual-$request->hargaBeli) * $request->jumlah ;
          


            Purchasing::create([
                'nomorFaktur' => rand(10000000, 99999999),
                'jumlah' => $request->jumlah,
                'hargaBeli' => $request->hargaBeli,
                'hargaJual' => $request->hargaJual,
                'keuntungan'=> $keuntungan,
                'tanggal' => now(),
                'idUser' => Auth::id(),
                'idCustomer' => $customer->idCustomer,
                'idProduct' => $product->idProduct,
            ]);

            // Simpan keuangan (dana keluar)
            Finance::create([
                'danaMasuk' => -$total,
                'modal' => -$total,
                'totalDana' => $keuntungan,
                'tanggal' => now(),
                'keuntungan' => $keuntungan,
            ]);

            DB::commit();
            return redirect()->route('purchasing.index')->with('success', 'Transaksi berhasil disimpan.');
            
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Gagal menyimpan transaksi: ' . $e->getMessage()]);
        }
    }
}
