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
public function index()
{
    $finances = Finance::with(['purchasings', 'sales'])->paginate(10); 
    $totalModal = Finance::sum('modal');
    $totalKeuntungan = Finance::sum('keuntungan');
    $totalDana = Finance::sum('keuntungan') + Finance::sum('modal');

    return view('finances.index', compact('finances', 'totalModal', 'totalKeuntungan', 'totalDana'));
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
