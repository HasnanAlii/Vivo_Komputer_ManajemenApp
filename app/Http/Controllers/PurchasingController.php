<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Purchasing;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Finance;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;

class PurchasingController extends Controller
{
    public function index()
    {
        try {
            $purchasings = Purchasing::with(['user', 'customer', 'product'])->get();
            return view('purchasings.index', compact('purchasings'));
        } catch (\Exception $e) {
            return redirect()->back()->with([
                'message' => 'Gagal mengambil data pembelian: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function indexx(Request $request)
    {
        try {
            $query = Purchasing::with(['customer', 'product']);

            if ($request->filter == 'today') {
                $query->whereDate('tanggal', Carbon::today());
            } elseif ($request->filter == 'week') {
                $query->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            } elseif ($request->filter == 'month') {
                $query->whereMonth('tanggal', Carbon::now()->month)
                      ->whereYear('tanggal', Carbon::now()->year);
            } elseif ($request->filter == 'year') {
                $query->whereYear('tanggal', Carbon::now()->year);
            }

            $purchasings = $query->paginate(8);
            $totalModal = $query->sum('hargaBeli');
            $totalKeuntungan = $query->sum('hargaJual') - $query->sum('hargaBeli');
            $totalPendapatan = $totalModal + $totalKeuntungan;

            return view('reports.purchasing', compact('purchasings', 'totalModal', 'totalKeuntungan', 'totalPendapatan'));
        } catch (Exception $e) {
            return redirect()->back()->with([
                'message' => 'Gagal memuat laporan pembelian: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function create()
    {
        try {
            $categories = Category::all();
            return view('purchasings.create', compact('categories'));
        } catch (Exception $e) {
            return redirect()->back()->with([
                'message' => 'Gagal membuka form pembelian: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'noTelp' => 'nullable|string|max:20',
            'alamat' => 'nullable|string|max:255',
            'namaBarang' => 'required|string|max:255',
            'idCategory' => 'required|exists:categories,idCategory',
            'jumlah' => 'required|integer|min:1',
            'hargaBeli' => 'required|numeric|min:0',
            'hargaJual' => 'required|numeric|min:0',
            'keterangan' => 'nullable|string|max:100',
        ]);

        DB::beginTransaction();

        try {
            $customer = Customer::create([
                'nama' => $request->nama,
                'noTelp' => $request->noTelp,
                'alamat' => $request->alamat,
            ]);

            $product = Product::where('namaBarang', $request->namaBarang)
                ->where('idCategory', $request->idCategory)
                ->first();

            if (!$product) {
                $product = Product::create([
                    'namaBarang' => $request->namaBarang,
                    'idCategory' => $request->idCategory,
                    'jumlah' => $request->jumlah,
                    'hargaBeli' => $request->hargaBeli,
                    'hargaJual' => $request->hargaJual,
                ]);
            } else {
                $product->jumlah += $request->jumlah;
                $product->hargaBeli = $request->hargaBeli;
                $product->hargaJual = $request->hargaJual;
                $product->save();
            }

            $total = $request->jumlah * $request->hargaBeli;
            $keuntungan = ($request->hargaJual - $request->hargaBeli) * $request->jumlah;

            $finance = Finance::create([
                'dana' => -$total,
                'modal' => $total,
                'totalDana' => $keuntungan,
                'tanggal' => now(),
                'keuntungan' => $keuntungan,
                'keterangan' => 'Pembelian produk',
            ]);

            Purchasing::create([
                'nomorFaktur' => rand(10000000, 99999999),
                'jumlah' => $request->jumlah,
                'hargaBeli' => $request->hargaBeli,
                'hargaJual' => $request->hargaJual,
                'keuntungan' => $keuntungan,
                'tanggal' => now(),
                'idCustomer' => $customer->idCustomer,
                'idProduct' => $product->idProduct,
                'idFinance' => $finance->idFinance,
            ]);

            DB::commit();

            return redirect()->route('purchasing.create')->with([
                'message' => 'Transaksi berhasil disimpan.',
                'alert-type' => 'success'
            ]);
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with([
                'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage(),
                'alert-type' => 'error'
            ]);
        }
    }
}
