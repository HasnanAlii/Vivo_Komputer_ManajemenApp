<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\MoneyOut;
use App\Models\User;
use App\Models\Sale;
use App\Models\Purchasing;
use App\Models\Service;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FinanceController extends Controller
{
public function index(Request $request)
{
    $filter = $request->input('filter', 'harian'); // default harian
    $date = $request->input('date', date('Y-m-d')); // default hari ini

    $query = Finance::with(['purchasings', 'sales']);

    switch ($filter) {
        case 'harian':
            $query->whereDate('tanggal', $date);
            break;

        case 'mingguan':
            // Ambil minggu berdasarkan tanggal
            $carbonDate = \Carbon\Carbon::parse($date);
            $startOfWeek = $carbonDate->startOfWeek(); // Senin
            $endOfWeek = $carbonDate->endOfWeek(); // Minggu
            $query->whereBetween('tanggal', [$startOfWeek, $endOfWeek]);
            break;

        case 'bulanan':
            $carbonDate = \Carbon\Carbon::parse($date);
            $query->whereYear('tanggal', $carbonDate->year)
                  ->whereMonth('tanggal', $carbonDate->month);
            break;

        case 'tahunan':
            $carbonDate = \Carbon\Carbon::parse($date);
            $query->whereYear('tanggal', $carbonDate->year);
            break;

        default:
            // Jika filter tidak valid, default ke harian
            $query->whereDate('tanggal', $date);
            break;
    }

    $finances = $query->paginate(10)->withQueryString();

    // Hitung total dari data yang sudah difilter
    $totalModal = $query->sum('modal');
    $totalKeuntungan = $query->sum('keuntungan');
    $totalDana = $totalModal + $totalKeuntungan;

    return view('finances.index', compact('finances', 'totalModal', 'totalKeuntungan', 'totalDana', 'filter', 'date'));
}



public function store(Request $request)
{
    $request->validate([
        'keterangan' => 'required|string|max:50',
        'jumlah' => 'required|integer|min:0',
        'tanggal' => 'required|date',
    ]);

   
    Finance::create([
        'dana' => -$request->jumlah, 
        'modal' => -$request->jumlah,  
        'tanggal' => $request->tanggal,
        'keterangan' => $request->keterangan,
    ]);
    MoneyOut::create([
        'keterangan' => $request->keterangan,
        'jumlah' => $request->jumlah,
        'tanggal' => $request->tanggal,
    ]);




    return redirect()->back()->with('success', 'Data dana keluar berhasil disimpan.');
}

public function storee(Request $request)
{
    $request->validate([
        'keterangan' => 'required|string|max:50',
        'jumlah' => 'required|integer|min:0',
        'tanggal' => 'required|date',
    ]);

   
    Finance::create([
        'dana' => $request->jumlah, 
        'modal' => $request->jumlah,  
        'tanggal' => $request->tanggal,
        'keterangan' => $request->keterangan,
    ]);



    return redirect()->back()->with('success', 'Data dana keluar berhasil disimpan.');
}




 
    public function destroy(Finance $finance)
    {
        $finance->delete();

        return redirect()->route('finances.index')->with('success', 'Finance record deleted successfully.');
    }
}
