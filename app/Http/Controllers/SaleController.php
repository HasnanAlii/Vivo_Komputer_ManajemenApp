<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Finance;
use App\Models\Sale;
use App\Models\Product;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{

    public function index(Request $request)
{
    if ($request->has('search') && !empty($request->search)) {
        if (is_numeric($request->search)) {
            $product = Product::find($request->search);
        } else {
            $product = Product::where('namaBarang', 'like', '%' . $request->search . '%')->first();
        }

        if ($product) {
            $salesWithNoFinance = Sale::whereNull('idFinance')->get();
            $existingFaktur = $salesWithNoFinance->first()->nomorFaktur ?? rand(10000000, 99999999);
            $existingSale = $salesWithNoFinance->where('idProduct', $product->idProduct)->first();

            if ($existingSale) {
                $existingSale->jumlah += 1;
                $existingSale->totalHarga = $existingSale->jumlah * $existingSale->hargaTransaksi;
                $existingSale->keuntungan = $existingSale->jumlah * ($existingSale->hargaTransaksi - $product->hargaBeli);
                $existingSale->save();
            } else {
                Sale::create([
                    'nomorFaktur' => $existingFaktur,
                    'jumlah' => 1,
                    'hargaTransaksi' => $product->hargaJual,
                    'totalHarga' => $product->hargaJual,
                    'keuntungan' => $product->hargaJual - $product->hargaBeli,
                    'tanggal' => now(),
                    'idProduct' => $product->idProduct,
                ]);
            }

            return redirect()->route('sales.index', ['customer' => $request->customer])
                ->with('success', 'Produk berhasil ditambahkan.');
        }

        return redirect()->route('sales.index', ['customer' => $request->customer])
            ->with('error', 'Produk tidak ditemukan.');
    }

    $sales = Sale::whereNull('idFinance')->with('product')->get();
    $total = $sales->sum(fn($s) => $s->jumlah * $s->hargaTransaksi);

    // ✅ Ambil idCustomer dari query string
    $customer = Customer::find($request->customer);

    return view('sales.index', compact('sales', 'customer', 'total'));
}


    public function indexx(Request $request)
    {
        $query = Sale::with(['product']);

        switch ($request->filter) {
            case 'today':
                $query->whereDate('tanggal', Carbon::today());
                break;
            case 'week':
                $query->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
                break;
            case 'month':
                $query->whereMonth('tanggal', Carbon::now()->month)
                      ->whereYear('tanggal', Carbon::now()->year);
                break;
            case 'year':
                $query->whereYear('tanggal', Carbon::now()->year);
                break;
        }

        $filteredQuery = clone $query;
        $sales = $query->paginate(8);

        $totalModal = $filteredQuery->sum('totalHarga') - $filteredQuery->sum('keuntungan');
        $totalKeuntungan = $filteredQuery->sum('keuntungan');
        $totalPendapatan = $totalModal + $totalKeuntungan;

        return view('reports.sale', compact('sales', 'totalModal', 'totalKeuntungan', 'totalPendapatan'));
    }

    public function create()
    {
        return view('sales.create', [
            'products' => Product::all(),
        ]);
    }

    public function store(Request $request)
    {
        $request->merge([
        'hargaTransaksi' => str_replace('.', '', $request->hargaTransaksi),
        'totalHarga' => str_replace('.', '', $request->totalHarga),
        'keuntungan' => str_replace('.', '', $request->keuntungan),
    ]);
        $request->validate([
            'nomorFaktur' => 'required|integer',
            'jumlah' => 'required|integer',
            'hargaTransaksi' => 'required|integer',
            'totalHarga' => 'required|integer',
            'keuntungan' => 'required|integer',
            'tanggal' => 'required|date',
            'idProduct' => 'required|exists:products,idProduct',
        ]);

        try {
            Sale::create($request->all());
            return redirect()->route('sales.index')->with('success', 'Transaksi berhasil ditambahkan.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
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
        $request->merge([
        'hargaTransaksi' => str_replace('.', '', $request->hargaTransaksi),
        'totalHarga' => str_replace('.', '', $request->totalHarga),
        'keuntungan' => str_replace('.', '', $request->keuntungan),
    ]);
        try {
            $sale = Sale::findOrFail($id);
            $sale->update($request->all());
            return redirect()->route('sales.index')->with('success', 'Transaksi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui transaksi: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            Sale::destroy($id);
            return redirect()->route('sales.index')->with('success', 'Produk berhasil dihapus.');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    public function increase($id)
    {
        try {
            $sale = Sale::findOrFail($id);
            $sale->jumlah += 1;
            $sale->totalHarga = $sale->jumlah * $sale->hargaTransaksi;
            $sale->keuntungan = $sale->jumlah * ($sale->hargaTransaksi - $sale->product->hargaBeli);
            $sale->save();

            return redirect()->route('sales.index')->with('success', 'Jumlah berhasil ditambah.');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('error', 'Gagal menambah jumlah: ' . $e->getMessage());
        }
    }

    public function decrease($id)
    {
        try {
            $sale = Sale::findOrFail($id);
            $sale->jumlah -= 1;
            $sale->totalHarga = $sale->jumlah * $sale->hargaTransaksi;
            $sale->keuntungan = $sale->jumlah * ($sale->hargaTransaksi - $sale->product->hargaBeli);
            $sale->save();

            return redirect()->route('sales.index')->with('success', 'Jumlah berhasil dikurangi.');
        } catch (\Exception $e) {
            return redirect()->route('sales.index')->with('error', 'Gagal mengurangi jumlah: ' . $e->getMessage());
        }
    }

public function checkout(Request $request)
{
        $request->merge([
        'bayar' => str_replace('.', '', $request->bayar),
        'total' => str_replace('.', '', $request->total),
    ]);
    $request->validate([
        'bayar' => 'required|numeric|min:0',
        'total' => 'required|numeric|min:0',
    ]);

    DB::beginTransaction();
    $sales = Sale::with('product')->whereNull('idFinance')->get();

    try {
        $totalBayar = $sales->sum(fn($s) => $s->jumlah * $s->hargaTransaksi);
        $totalModal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaBeli);
        $totalKeuntungan = $totalBayar - $totalModal;

        $bayar = $request->bayar;
        $sisaCicilan = max($totalBayar - $bayar, 0);
        $idCustomer = $request->input('idCustomer');

        if ($sales->isEmpty()) {
            DB::rollBack();
            return redirect()->route('sales.index')->with([
                'message' => 'Tidak ada item yang dibeli.',
                'alert-type' => 'error'
            ]);
        }

       
        $statusPembayaran = $bayar == 0 ? 'cicilan' : ($sisaCicilan > 0 ? 'sebagian' : 'lunas');

        // Jika bayar = 0, set modal dan keuntungan jadi 0
        $financeModal = $bayar == 0 ? 0 : $totalModal;
        $financeKeuntungan = $bayar == 0 ? 0 : $totalKeuntungan;
        

        // Simpan data finance
        $finance = new Finance();
        $finance->dana = $bayar;
        $finance->modal = $financeModal;
        $finance->keuntungan = $financeKeuntungan;
        $finance->totalDana = $totalBayar;
        $finance->sisa_cicilan = $sisaCicilan;
        $finance->status_pembayaran = $statusPembayaran;
        $finance->tanggal = now()->toDateString();
        $finance->keterangan = 'penjualan produk';
        $finance->save();

        // Jika customer belum dipilih dan ada sisa cicilan, buat baru
        if (!$idCustomer && $sisaCicilan > 0) {
            $customer = Customer::create([
                'nama' => 'Customer Baru',
                'idFinance' => $finance->idFinance,
            ]);
            $idCustomer = $customer->idCustomer;
        }

        // Jika customer sudah ada dan ada sisa cicilan, tambahkan cicilannya
        if ($idCustomer && $sisaCicilan > 0) {
            $customer = Customer::find($idCustomer);
            if ($customer) {
                if (!$customer->wasRecentlyCreated) {
                    $customer->cicilan += $sisaCicilan;
                }
                $customer->idFinance = $finance->idFinance;
                $customer->save();
            }
        }

        foreach ($sales as $sale) {
            $product = $sale->product;

            if ($product->jumlah < $sale->jumlah) {
                throw new \Exception("Stok barang '{$product->namaBarang}' tidak mencukupi.");
            }

            $product->jumlah -= $sale->jumlah;
            $product->save();

            $sale->idFinance = $finance->idFinance;
            $sale->totalHarga = $sale->jumlah * $sale->hargaTransaksi;
            $sale->keuntungan = $bayar == 0 ? 0 : $totalKeuntungan;
            $sale->tanggal = now();
            $sale->idCustomer = $idCustomer;
            $sale->save();

            TransactionItem::create([
                'idSale' => $sale->idSale,
                'idProduct' => $product->idProduct,
                'namaBarang' => $product->namaBarang,
                'hargaTransaksi' => $sale->hargaTransaksi,
                'jumlah' => $sale->jumlah,
            ]);
        }

        DB::commit();
        session()->flash('bayar', $bayar);

        return redirect()->route('sales.print', ['id' => $finance->idFinance])->with([
            'message' => 'Transaksi berhasil diselesaikan.',
            'alert-type' => 'success'
        ]);
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->route('sales.index')->with([
            'message' => 'Gagal menyelesaikan transaksi: ' . $e->getMessage(),
            'alert-type' => 'error'
        ]);
    }
}




public function editPrice(Request $request, $id)
{
     $request->merge([
        'hargaTransaksi' => str_replace('.', '', $request->hargaTransaksi),
    ]);

    $request->validate([
        'hargaTransaksi' => 'required|numeric|min:0',
    ]);

    try {
        $sale = Sale::findOrFail($id);
        $sale->hargaTransaksi = $request->hargaTransaksi;
        $sale->totalHarga = $sale->jumlah * $sale->hargaTransaksi;
        $sale->keuntungan = $sale->jumlah * ($sale->hargaTransaksi - $sale->product->hargaBeli);
        $sale->save();

        return redirect()->route('sales.index')->with('success', 'Harga berhasil diubah.');
    } catch (\Exception $e) {
        return redirect()->route('sales.index')->with('error', 'Gagal mengubah harga: ' . $e->getMessage());
    }
}

    public function printReceipt($id)
    {
        $sales = Sale::with(['product', 'finance'])->where('idFinance', $id)->get();

        if ($sales->isEmpty()) {
            return redirect()->route('sales.index')->with('error', 'Transaksi tidak ditemukan.');
        }

        $total = $sales->sum('totalHarga');
        $modal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaBeli);
        $bayar = session('bayar') ?? $sales->first()->finance->dana ?? $total;
        $kembalian = $bayar - $total;
        $nomorFaktur = $sales->first()->nomorFaktur ?? '-';

        return view('sales.receipt', compact('sales', 'total', 'bayar', 'kembalian', 'modal', 'nomorFaktur'));
    }

    public function searchProducts(Request $request)
    {
        $search = $request->get('q');

        $products = Product::where('namaBarang', 'like', '%' . $search . '%')
            ->limit(10)
            ->get(['idProduct as id', 'namaBarang as text']);

        return response()->json(['results' => $products]);
    }
}