<?php

namespace App\Http\Controllers;

use App\Models\Purchasing;
use App\Models\Product;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;

class PurchasingController extends Controller
{
    public function index() {
        $purchasings = Purchasing::with(['product', 'user', 'customer'])->get();
        return view('purchasings.index', compact('purchasings'));
    }

    public function create() {
        return view('purchasings.create', [
            'products' => Product::all(),
            'users' => User::all(),
            'customers' => Customer::all()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nomorFaktur' => 'required|integer',
            'jumlah' => 'required|integer',
            'hargaBeli' => 'required|integer',
            'hargaJual' => 'required|integer',
            'keuntungan' => 'required|integer',
            'tanggal' => 'required|date',
            'idUser' => 'required|exists:users,idUser',
            'idCustomer' => 'required|exists:customers,idCustomer',
            'idProduct' => 'required|exists:products,idProduct',
        ]);

        Purchasing::create($request->all());
        return redirect()->route('purchasings.index');
    }

    public function edit($id) {
        return view('purchasings.edit', [
            'purchasing' => Purchasing::findOrFail($id),
            'products' => Product::all(),
            'users' => User::all(),
            'customers' => Customer::all()
        ]);
    }

    public function update(Request $request, $id) {
        $purchasing = Purchasing::findOrFail($id);
        $purchasing->update($request->all());
        return redirect()->route('purchasings.index');
    }

    public function destroy($id) {
        Purchasing::destroy($id);
        return redirect()->route('purchasings.index');
    }
}
