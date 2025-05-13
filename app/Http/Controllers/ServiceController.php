<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index() {
        $services = Service::with(['customer', 'product', 'user'])->get();
        return view('services.index', compact('services'));
    }

    public function create() {
        return view('services.create', [
            'customers' => Customer::all(),
            'products' => Product::all(),
            'users' => User::all()
        ]);
    }

    public function store(Request $request) {
        $request->validate([
            'nomorFaktur' => 'required|integer',
            'kerusakan' => 'required|string|max:50',
            'jenisPerangkat' => 'required|string|max:50',
            'status' => 'boolean',
            'totalBiaya' => 'required|integer',
            'keuntungan' => 'required|integer',
            'tglMasuk' => 'required|date',
            'tglSelesai' => 'required|date',
            'idCustomer' => 'required|exists:customers,idCustomer',
            'idProduct' => 'required|exists:products,idProduct',
            'idUser' => 'required|exists:users,idUser',
        ]);

        Service::create($request->all());
        return redirect()->route('services.index');
    }

    public function edit($id) {
        return view('services.edit', [
            'service' => Service::findOrFail($id),
            'customers' => Customer::all(),
            'products' => Product::all(),
            'users' => User::all()
        ]);
    }

    public function update(Request $request, $id) {
        $service = Service::findOrFail($id);
        $service->update($request->all());
        return redirect()->route('services.index');
    }

    public function destroy($id) {
        Service::destroy($id);
        return redirect()->route('services.index');
    }
}
