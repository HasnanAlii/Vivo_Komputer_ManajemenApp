<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index() {
        $sales = Sale::with(['product', 'user'])->get();
        return view('sales.index', compact('sales'));
    }

    public function create() {
        return view('sales.create', [
            'products' => Product::all(),
            'users' => User::all()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nomorFaktur' => 'required|integer',
            'jumlah' => 'required|integer',
            'totalHarga' => 'required|integer',
            'keuntungan' => 'required|integer',
            'tanggal' => 'required|date',
            'idUser' => 'required|exists:users,idUser',
            'idProduct' => 'required|exists:products,idProduct',
        ]);

        Sale::create($request->all());
        return redirect()->route('sales.index');
    }

    public function edit($id) {
        return view('sales.edit', [
            'sale' => Sale::findOrFail($id),
            'products' => Product::all(),
            'users' => User::all()
        ]);
    }

    public function update(Request $request, $id) {
        $sale = Sale::findOrFail($id);
        $sale->update($request->all());
        return redirect()->route('sales.index');
    }

    public function destroy($id) {
        Sale::destroy($id);
        return redirect()->route('sales.index');
    }
}
