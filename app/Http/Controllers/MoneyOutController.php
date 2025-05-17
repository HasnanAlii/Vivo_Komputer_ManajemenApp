<?php

namespace App\Http\Controllers;

use App\Models\MoneyOut;
use Carbon\Carbon;
use Illuminate\Http\Request;

class MoneyOutController extends Controller
{
     public function index(Request $request)
    {
        $filter = $request->input('filter', 'harian'); // default harian
        $date = $request->input('date', Carbon::today()->toDateString());
        $totalPengeluaran = MoneyOut::sum('jumlah');


        switch ($filter) {
            case 'harian':
                $MoneyOut = MoneyOut::whereDate('tanggal', $date)->get();
                break;

            case 'mingguan':
                $dateCarbon = Carbon::parse($date);
                $startOfWeek = $dateCarbon->startOfWeek(); // Senin
                $endOfWeek = $dateCarbon->endOfWeek(); // Minggu
                $MoneyOut = MoneyOut::whereBetween('tanggal', [$startOfWeek, $endOfWeek])->get();
                break;

            case 'bulanan':
                $dateCarbon = Carbon::parse($date);
                $MoneyOut = MoneyOut::whereYear('tanggal', $dateCarbon->year)
                                 ->whereMonth('tanggal', $dateCarbon->month)
                                 ->get();
                break;

            case 'tahunan':
                $dateCarbon = Carbon::parse($date);
                $MoneyOut = MoneyOut::whereYear('tanggal', $dateCarbon->year)->get();
                break;

            default:
                $MoneyOut = MoneyOut::all();
                break;
        }

        return view('finances.moneyout', compact('MoneyOut', 'filter', 'date','totalPengeluaran'));
    }
}

