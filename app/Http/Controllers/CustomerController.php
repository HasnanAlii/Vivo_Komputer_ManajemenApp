<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::all();
        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'noTelp' => 'required|string|max:15',
        ]);

        Customer::create($request->all());
        return redirect()->route('customers.index')->with('success', 'Customer created.');
    }

    public function edit($id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->update($request->all());

        return redirect()->route('customers.index')->with('success', 'Customer updated.');
    }

    public function destroy($id)
    {
        Customer::destroy($id);
        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }
}


