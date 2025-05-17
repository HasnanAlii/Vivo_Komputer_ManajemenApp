<?php

namespace App\Http\Controllers;


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

    $query = Sale::with('product.category');

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

    $sales = $query->get();

    $totalModal = $sales->sum(fn($s) => $s->jumlah * $s->product->hargaBeli);
    $totalPendapatan = $sales->sum('totalHarga');
    $totalKeuntungan = $sales->sum('keuntungan');

    $pdf = Pdf::loadView('reports.sales_pdf', compact(
        'sales', 'totalModal', 'totalPendapatan', 'totalKeuntungan', 'filter'
    ))->setPaper('A4', 'landscape');

    return $pdf->stream('laporan_penjualan.pdf');
}
public function printtt(Request $request)
{
     $filter = $request->get('filter');

    $services = Service::with(['customer', 'products'])
        ->when($filter == 'today', fn($q) => $q->whereDate('tglMasuk', now()))
        ->when($filter == 'week', fn($q) => $q->whereBetween('tglMasuk', [now()->startOfWeek(), now()->endOfWeek()]))
        ->when($filter == 'month', fn($q) => $q->whereMonth('tglMasuk', now()->month))
        ->when($filter == 'year', fn($q) => $q->whereYear('tglMasuk', now()->year))
        ->get();

  
    $totalModal = $services->sum('totalHarga') - $services->sum('biayaJasa');
    $totalKeuntungan = $services->sum('biayaJasa');
    $totalPendapatan= $services->sum('totalHarga');

    $pdf = Pdf::loadView('reports.service_pdf', [
        'services' => $services,
        'totalModal' => $totalModal,
        'totalPendapatan' => $totalPendapatan,
        'totalKeuntungan' => $totalKeuntungan,
        'filter' => $filter,
    ])->setPaper('A4', 'landscape');

    return $pdf->stream('laporan-service.pdf');
}
}
