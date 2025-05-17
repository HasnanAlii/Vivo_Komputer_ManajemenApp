<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Sale;
use App\Models\Purchasing;
use App\Models\Service;
use App\Models\Finance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use \Illuminate\Database\Eloquent\Builder;

class ReportController extends Controller
{
public function index()
{
    return view('reports.index');
}
public function print(Request $request)
{
    // logika serupa seperti index untuk ambil $purchasings dengan filter
    $query = Purchasing::with(['customer', 'product']);

    // filter logika sama seperti di atas...

    $purchasings = $query->get();

    $pdf = PDF::loadView('purchasing.pdf', compact('purchasings'));
    return $pdf->stream('laporan-pembelian.pdf');
}
public function printt(Request $request)
{
    // logika serupa seperti index untuk ambil $purchasings dengan filter
    $query = Purchasing::with(['customer', 'product']);

    // filter logika sama seperti di atas...

    $purchasings = $query->get();

    $pdf = Pdf::loadView('purchasing.pdf', compact('purchasings'));
    return $pdf->stream('laporan-pembelian.pdf');
}
public function printtt(Request $request)
{
    // logika serupa seperti index untuk ambil $purchasings dengan filter
    $query = Purchasing::with(['customer', 'product']);

    // filter logika sama seperti di atas...

    $purchasings = $query->get();

    $pdf = PDF::loadView('purchasing.pdf', compact('purchasings'));
    return $pdf->stream('laporan-pembelian.pdf');
}
}
