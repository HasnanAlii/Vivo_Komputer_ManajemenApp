<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\User;
use App\Models\Sale;
use App\Models\Purchasing;
use App\Models\Service;
use App\Models\Product;
use Illuminate\Http\Request;

class FinanceController extends Controller
{
    public function index()
    {
        $finances = Finance::all();
        return view('finances.index', compact('finances'));
    }

    public function create()
    {
        $users = User::all();
        $sales = Sale::all();
        $purchasings = Purchasing::all();
        $services = Service::all();
        $products = Product::all();

        return view('finances.create', compact('users', 'sales', 'purchasings', 'services', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'danaMasuk' => 'required|integer',
            'modal' => 'required|integer',
            'totalDana' => 'required|integer',
            'tanggal' => 'required|date',
            'keuntungan' => 'required|integer',
            'idUser' => 'nullable|exists:users,idUser',
            'idSale' => 'nullable|exists:sales,idSale',
            'idPurchasing' => 'nullable|exists:purchasings,idPurchasing',
            'idService' => 'nullable|exists:services,idService',
            'idProduct' => 'required|exists:products,idProduct',
        ]);

        Finance::create($request->all());

        return redirect()->route('finances.index')->with('success', 'Finance record created successfully.');
    }

    public function edit(Finance $finance)
    {
        $users = User::all();
        $sales = Sale::all();
        $purchasings = Purchasing::all();
        $services = Service::all();
        $products = Product::all();

        return view('finances.edit', compact('finance', 'users', 'sales', 'purchasings', 'services', 'products'));
    }

    public function update(Request $request, Finance $finance)
    {
        $request->validate([
            'danaMasuk' => 'required|integer',
            'modal' => 'required|integer',
            'totalDana' => 'required|integer',
            'tanggal' => 'required|date',
            'keuntungan' => 'required|integer',
            'idUser' => 'nullable|exists:users,idUser',
            'idSale' => 'nullable|exists:sales,idSale',
            'idPurchasing' => 'nullable|exists:purchasings,idPurchasing',
            'idService' => 'nullable|exists:services,idService',
            'idProduct' => 'required|exists:products,idProduct',
        ]);

        $finance->update($request->all());

        return redirect()->route('finances.index')->with('success', 'Finance record updated successfully.');
    }

    public function destroy(Finance $finance)
    {
        $finance->delete();

        return redirect()->route('finances.index')->with('success', 'Finance record deleted successfully.');
    }
}
