<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Purchasing;
use App\Models\Customer;
use App\Models\Product;
use App\Models\Finance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Exception;

class PurchasingController extends Controller
{
    public function index()
    {
        try {
            $purchasings = Purchasing::with(['user', 'customer', 'product'])->get();
            return view('purchasings.index', compact('purchasings'));
        } catch (Exception $e) {
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
       public function createe()
        {
    try {
        $categories = Category::all();
        $customers = Customer::all();  // <-- ambil semua customer

        return view('purchasings.create2', compact('categories', 'customers'));
    } catch (Exception $e) {
        return redirect()->back()->with([
            'message' => 'Gagal membuka form pembelian: ' . $e->getMessage(),
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
public function storee(Request $request)
{
    $request->validate([
        'idCustomer' => 'required|exists:customers,idCustomer', 
        'namaBarang' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'spek' => 'required|string|max:255',
        'serialNumber' => 'nullable|string|max:255',
        'idCategory' => 'required|exists:categories,idCategory',
        'jumlah' => 'required|string|min:1',
        'hargaBeli' => 'required|string',
        'hargaJual' => 'required|string',
        'keterangan' => 'nullable|string|max:100',
        'buktiTransaksi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
    ]);

    $request->merge([
        'hargaBeli' => str_replace('.', '', $request->hargaBeli),
        'hargaJual' => str_replace('.', '', $request->hargaJual),
        'jumlah' => str_replace('.', '', $request->jumlah),
    ]);

    $hargaBeli = (int) $request->hargaBeli;
    $hargaJual = (int) $request->hargaJual;

    DB::beginTransaction();

    try {
        // Hanya gunakan customer dari request, tanpa membuat baru
        $customer = Customer::findOrFail($request->idCustomer);

        $product = Product::where('namaBarang', $request->namaBarang)
            ->where('idCategory', $request->idCategory)
            ->first();

        if (!$product) {
            $product = Product::create([
                'namaBarang' => $request->namaBarang,
                'idCategory' => $request->idCategory,
                'jumlah' => $request->jumlah,
                'hargaBeli' => $hargaBeli,
                'hargaJual' => $hargaJual,
            ]);
        } else {
            $product->jumlah += $request->jumlah;
            $product->hargaBeli = $hargaBeli;
            $product->hargaJual = $hargaJual;
            $product->save();
        }

        $total = $request->jumlah * $hargaBeli;

        $finance = Finance::create([
            'dana' => -$total,
            'modal' => -$total,
            'tanggal' => now(),
            'keterangan' => 'Pembelian produk',
        ]);

        $pathBukti = null;
        if ($request->hasFile('buktiTransaksi')) {
            $file = $request->file('buktiTransaksi');
            $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/bukti_transaksi'), $namaFile);
            $pathBukti = 'uploads/bukti_transaksi/' . $namaFile;
        }

        $purchasing = Purchasing::create([
            'nomorFaktur' => rand(10000000, 99999999),
            'jumlah' => $request->jumlah,
            'hargaBeli' => $hargaBeli,
            'hargaJual' => $hargaJual,
            'type' => $request->type,
            'spek' => $request->spek,
            'serialNumber' => $request->serialNumber,
            'tanggal' => now(),
            'idCustomer' => $customer->idCustomer,
            'idProduct' => $product->idProduct,
            'idFinance' => $finance->idFinance,
            'buktiTransaksi' => $pathBukti,
        ]);

        DB::commit();

        return redirect()->route('purchasing.index')->with([
            'message' => 'Transaksi berhasil disimpan.',
            'alert-type' => 'success'
        ]);
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->with([
            'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage(),
            'alert-type' => 'error'
        ]);
    }
}


  public function store(Request $request)
{
    $request->validate([
        'nama' => 'nullable|string|max:255',
        'noTelp' => 'nullable|string|max:20',
        'alamat' => 'nullable|string|max:255',
        'noKtp' => 'nullable|string|max:20',
        'namaBarang' => 'required|string|max:255',
        'type' => 'required|string|max:255',
        'spek' => 'required|string|max:255',
        'serialNumber' => 'nullable|string|max:255',
        'idCategory' => 'required|exists:categories,idCategory',
        'jumlah' => 'required|string|min:1',
        'hargaBeli' => 'required|string',  // ubah jadi string karena ada titik
        'hargaJual' => 'required|string',
        'keterangan' => 'nullable|string|max:100',
        'buktiTransaksi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
    ]);

    // Hilangkan titik pada hargaBeli dan hargaJual agar jadi angka murni
   $request->merge([
        'hargaBeli' => str_replace('.', '', $request->hargaBeli),
        'hargaJual' => str_replace('.', '', $request->hargaJual),
        'jumlah' => str_replace('.', '', $request->jumlah),

    ]);

    // Jika kamu mau, kamu bisa convert ke integer setelah hapus titik
    $hargaBeli = (int) $request->hargaBeli;
    $hargaJual = (int) $request->hargaJual;

    DB::beginTransaction();

    try {
        $customer = Customer::create([
            'nama' => $request->nama,
            'noTelp' => $request->noTelp,
            'alamat' => $request->alamat,
            'noKtp' => $request->noKtp
        ]);

        $product = Product::where('namaBarang', $request->namaBarang)
            ->where('idCategory', $request->idCategory)
            ->first();

        if (!$product) {
            $product = Product::create([
                'namaBarang' => $request->namaBarang,
                'idCategory' => $request->idCategory,
                'jumlah' => $request->jumlah,
                'hargaBeli' => $hargaBeli,
                'hargaJual' => $hargaJual,
            ]);
        } else {
            $product->jumlah += $request->jumlah;
            $product->hargaBeli = $hargaBeli;
            $product->hargaJual = $hargaJual;
            $product->save();
        }

        $total = $request->jumlah * $hargaBeli;

        $finance = Finance::create([
            'dana' => -$total,
            'modal' => -$total,
            'tanggal' => now(),
            'keterangan' => 'Pembelian produk',
        ]);

        $pathBukti = null;
        if ($request->hasFile('buktiTransaksi')) {
            $file = $request->file('buktiTransaksi');
            $namaFile = time() . '_' . preg_replace('/\s+/', '_', $file->getClientOriginalName());
            $file->move(public_path('uploads/bukti_transaksi'), $namaFile);
            $pathBukti = 'uploads/bukti_transaksi/' . $namaFile;
        }

        $purchasing = Purchasing::create([
            'nomorFaktur' => rand(10000000, 99999999),
            'jumlah' => $request->jumlah,
            'hargaBeli' => $hargaBeli,
            'hargaJual' => $hargaJual,
            'type' => $request->type,
            'spek' => $request->spek,
            'serialNumber' => $request->serialNumber,
            'tanggal' => now(),
            'idCustomer' => $customer->idCustomer,
            'idProduct' => $product->idProduct,
            'idFinance' => $finance->idFinance,
            'buktiTransaksi' => $pathBukti,
        ]);

        DB::commit();

        return redirect()->route('purchasing.index', $purchasing)->with([
            'message' => 'Transaksi berhasil disimpan.',
            'alert-type' => 'success'
        ]);
    } catch (Exception $e) {
        DB::rollBack();
        return redirect()->back()->withInput()->with([
            'message' => 'Gagal menyimpan transaksi: ' . $e->getMessage(),
            'alert-type' => 'error'
        ]);
    }
}



    public function show(Purchasing $purchasing)
    {
        $purchasing->load(['customer', 'product', 'category']);
        return view('purchasings.print', compact('purchasing'));
    }
}
