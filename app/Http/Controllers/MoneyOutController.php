<?php

namespace App\Http\Controllers;

use App\Models\MoneyOut;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MoneyOutController extends Controller
{
 public function index(Request $request)
{
    $filter = $request->input('filter', 'harian');
    $date = $request->input('date', \Carbon\Carbon::today()->toDateString());
    $dateCarbon = \Carbon\Carbon::parse($date);

    // Query utama
    $MoneyOutQuery = MoneyOut::query();

    // Terapkan filter tanggal
    switch ($filter) {
        case 'harian':
            $MoneyOutQuery->whereDate('tanggal', $dateCarbon);
            break;

        case 'mingguan':
            $startOfWeek = $dateCarbon->copy()->startOfWeek();
            $endOfWeek = $dateCarbon->copy()->endOfWeek();
            $MoneyOutQuery->whereBetween('tanggal', [$startOfWeek, $endOfWeek]);
            break;

        case 'bulanan':
            $MoneyOutQuery->whereYear('tanggal', $dateCarbon->year)
                          ->whereMonth('tanggal', $dateCarbon->month);
            break;

        case 'tahunan':
            $MoneyOutQuery->whereYear('tanggal', $dateCarbon->year);
            break;
    }

    // Clone query untuk total agar tidak terkena pagination
    $totalQuery = clone $MoneyOutQuery;

    // Pagination hasil
    $MoneyOut = $MoneyOutQuery->orderByDesc('tanggal')->paginate(10)->withQueryString();

    // Total pengeluaran
    $totalPengeluaran = $totalQuery->sum('jumlah');

    return view('finances.moneyout', compact('MoneyOut', 'filter', 'date', 'totalPengeluaran'));
}


public function exportPDFF(Request $request)
{
    $filter = $request->input('filter', 'harian');
    $date = $request->input('date', Carbon::today()->toDateString());
    $dateCarbon = Carbon::parse($date);

    $MoneyOutQuery = MoneyOut::query();

    switch ($filter) {
        case 'harian':
            $MoneyOutQuery->whereDate('tanggal', $dateCarbon);
            break;
        case 'mingguan':
            $MoneyOutQuery->whereBetween('tanggal', [$dateCarbon->startOfWeek(), $dateCarbon->endOfWeek()]);
            break;
        case 'bulanan':
            $MoneyOutQuery->whereYear('tanggal', $dateCarbon->year)
                          ->whereMonth('tanggal', $dateCarbon->month);
            break;
        case 'tahunan':
            $MoneyOutQuery->whereYear('tanggal', $dateCarbon->year);
            break;
    }

    $MoneyOut = $MoneyOutQuery->orderByDesc('tanggal')->paginate(7);
    $totalPengeluaran = $MoneyOutQuery->sum('jumlah'); ;

    $pdf = Pdf::loadView('finances.pdf', compact('MoneyOut', 'filter', 'date', 'totalPengeluaran'))
             ->setPaper('a4', 'portrait');

    return $pdf->stream('laporan_pengeluaran.pdf'); 
}
}

