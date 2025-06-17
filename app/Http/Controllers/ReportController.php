<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Employee;
use App\Models\Finance;
use App\Models\Sale;
use App\Models\Purchasing;
use App\Models\Service;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;


class ReportController extends Controller
{
public function index()
{
    return view('reports.index');
}



public function cetakhutang($id)
{
    $customer = Customer::with(['sales.product', 'pembayaran'])->findOrFail($id);

    return view('reports.cetakhutang', compact('customer'));
}


public function print(Request $request)
{
    $filter = $request->get('filter');

    $query = Purchasing::with('customer', 'product');

    switch ($filter) {
        case 'today':
            $query->whereDate('tanggal', Carbon::today());
            break;
        case 'week':
            $query->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            break;
        case 'month':
            $query->whereMonth('tanggal', Carbon::now()->month);
            break;
        case 'year':
            $query->whereYear('tanggal', Carbon::now()->year);
            break;
    }

    $purchasings = $query->get();
    $totalModal = $purchasings->sum(fn($p) => $p->jumlah * $p->hargaBeli);
    $totalPendapatan = $purchasings->sum(fn($p) => $p->jumlah * $p->hargaJual);
    $totalKeuntungan = $totalPendapatan - $totalModal;

    $pdf = Pdf::loadView('reports.purchasings_pdf', compact(
        'purchasings', 'totalModal', 'totalPendapatan', 'totalKeuntungan', 'filter'
    ))->setPaper('A4', 'landscape');

    return $pdf->stream('laporan_pembelian.pdf');
}
public function printt(Request $request)
{
    $filter = $request->get('filter');
    $idEmployee = $request->get('idEmployee');

    $query = Sale::with(['product', 'employee']);

    switch ($filter) {
        case 'harian':
            $query->whereDate('tanggal', Carbon::today());
            break;
        case 'mingguan':
            $query->whereBetween('tanggal', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
            break;
        case 'bulanan':
            $query->whereMonth('tanggal', Carbon::now()->month);
            break;
        case 'tahunan':
            $query->whereYear('tanggal', Carbon::now()->year);
            break;
    }

    if ($idEmployee) {
        $query->where('idEmployee', $idEmployee);
    }

    $sales = $query->get();

    $totalModal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaBeli);
    $totalPendapatan = $sales->sum('totalHarga');
    $totalKeuntungan = $sales->sum('keuntungan');
    

    
    $pdf = Pdf::loadView('reports.sales_pdf',[
    'employee' => $idEmployee ? Employee::find($idEmployee) : null

     ], compact(
        'sales', 'totalModal', 'totalPendapatan', 'totalKeuntungan', 'filter'
    ))->setPaper('A4', 'landscape');

    return $pdf->stream('laporan_penjualan.pdf');
}

public function printtt(Request $request)
{
    $filter = $request->get('filter');
    $idEmployee = $request->get('idEmployee');

    $query = Service::with(['customer', 'products', 'employee'])
        ->when($filter == 'harian', fn($q) => $q->whereDate('tglMasuk', now()))
        ->when($filter == 'mingguan', fn($q) => $q->whereBetween('tglMasuk', [now()->startOfWeek(), now()->endOfWeek()]))
        ->when($filter == 'bulanan', fn($q) => $q->whereMonth('tglMasuk', now()->month))
        ->when($filter == 'tahunan', fn($q) => $q->whereYear('tglMasuk', now()->year))
        ->when($idEmployee, fn($q) => $q->where('idEmployee', $idEmployee));

    $services = $query->get();

    $totalModal = $services->sum(fn($item) => $item->totalHarga - $item->biayaJasa);
    $totalKeuntungan = $services->sum('biayaJasa');
    $totalPendapatan = $services->sum('totalHarga');

    $pdf = Pdf::loadView('reports.service_pdf', [
        'services' => $services,
        'totalModal' => $totalModal,
        'totalPendapatan' => $totalPendapatan,
        'totalKeuntungan' => $totalKeuntungan,
        'filter' => $filter,
        'employee' => $idEmployee ? Employee::find($idEmployee) : null
    ])->setPaper('A4', 'landscape');

    return $pdf->stream('laporan-service.pdf');
}

public function customers()
{
    $customers = Customer::with(['sales.product', 'purchasings', 'services'])->get();

    foreach ($customers as $customer) {
        $totalSales = $customer->sales->sum(function ($sale) {
            return $sale->product->hargaJual ?? 0;
        });

        // $totalPurchases = $customer->purchasings->sum('hargaBeli');

        $totalServiceCost = $customer->services->sum('totalHarga');

        $customer->totalTransaksi = $totalSales + $totalServiceCost;
    }
    return view('reports.customers', compact('customers'));
}
public function customer()
{
   $customers = Customer::with(['pembayaran','sales.product'])->where('cicilan', '>', 0)->get();

    return view('reports.hutang', compact('customers'));
}

  public function destroyy($id)
{
    try {
        Customer::destroy($id);
        $notification = [
            'message' => 'Customer berhasil dihapus.',
            'alert-type' => 'success'
        ];
        return redirect()->route('reports.customer')->with($notification);
    } catch (\Exception $e) {
        $notification = [
            'message' => 'Gagal menghapus customer: ' . $e->getMessage(),
            'alert-type' => 'error'
        ];
        return redirect()->route('reports.customer')->with($notification);
    }
}

public function pay(Request $request)
{
    // Ambil data penjualan
    $sale = Sale::findOrFail($request->idSale);

    // Simpan ke tabel finance
    $finance = new Finance();
    $finance->idSale = $sale->idSale;
    $finance->pemasukan = $sale->totalHarga; // Atau sesuai kebutuhan
    $finance->pengeluaran = 0;
    $finance->keuntungan = $sale->keuntungan;
    $finance->tanggal = now(); // Atur sesuai kebutuhan
    $finance->save();

    // Update sale jika perlu (misalnya status lunas)
    $sale->status = 'lunas';
    $sale->idFinance = $finance->idFinance;
    $sale->save();

    return redirect()->back()->with('success', 'Pembayaran berhasil dan data keuangan tercatat.');
}
}
