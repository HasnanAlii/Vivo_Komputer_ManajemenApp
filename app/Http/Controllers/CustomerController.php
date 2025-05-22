<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Finance;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::with(['purchasings.product.sale'])->get();

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


public function edit($idCustomer)
{
    $customer = Customer::findOrFail($idCustomer);
    return view('reports.editcustomer', compact('customer'));
}

public function update(Request $request, $idCustomer)
{
    $request->validate([
        'nama'    => 'nullable|string|max:50',
        'alamat'  => 'nullable|string|max:255',
        'noTelp'  => 'nullable|string|max:255',
        'noKtp'   => 'nullable|string|max:255',
    ]);

    $customer = Customer::findOrFail($idCustomer);
    $customer->nama   = $request->nama;
    $customer->alamat = $request->alamat;
    $customer->noTelp = $request->noTelp;
    $customer->noKtp  = $request->noKtp;
    $customer->save();

    return redirect()->route('reports.customer')->with('success', 'Data customer berhasil diperbarui.');
}


    public function destroy($id)
    {
        Customer::destroy($id);
        return redirect()->route('customers.index')->with('success', 'Customer deleted.');
    }
    // Tampilkan form edit cicilan
public function editCicilan($idCustomer)
{
    $customer = Customer::findOrFail($idCustomer);
    return view('reports.cicilanEdit', compact('customer'));
}

public function updateCicilan(Request $request, $idCustomer)
{
    // Hapus titik dari angka cicilan (misal: 1.000.000 -> 1000000)
    $request->merge([
        'cicilan' => str_replace('.', '', $request->cicilan),
    ]);

    // Validasi input
    $request->validate([
        'cicilan' => 'required|string|min:0',
    ]);

    // Ambil data customer
    $customer = Customer::findOrFail($idCustomer);
    $jumlahBayar = (int) $request->cicilan;
    $sisaCicilan = $customer->cicilan - $jumlahBayar;

    // Validasi jika kelebihan bayar
    if ($sisaCicilan < 0) {
        return redirect()->back()->with('error', 'Jumlah pembayaran melebihi cicilan.');
    }

    // Ambil data sale terakhir customer
    $sale = Sale::where('idCustomer', $idCustomer)->latest()->first();
    if (!$sale) {
        return redirect()->back()->with('error', 'Data penjualan terkait customer tidak ditemukan.');
    }

    // Hitung modal dan keuntungan dari relasi produk
    $modal = $sale->product->hargaBeli;
    $keuntungan = $sale->hargaTransaksi - $modal;

    // Update sisa cicilan
    $customer->cicilan = $sisaCicilan;
    $customer->save();

    // Simpan data finance
    $finance = new Finance();
    $finance->dana = $jumlahBayar;
    $finance->modal = ($sisaCicilan == 0) ? $modal : 0;
    $finance->keuntungan = ($sisaCicilan == 0) ? $keuntungan : 0;
    $finance->totalDana = $jumlahBayar;
    $finance->sisa_cicilan = $sisaCicilan;
    $finance->tanggal = now()->toDateString();
    $finance->keterangan = 'Pembayaran cicilan oleh customer ' . $customer->nama;
    $finance->save();

    // Simpan idFinance ke customer jika tersedia
    if (Schema::hasColumn('customers', 'idFinance')) {
        $customer->idFinance = $finance->idFinance;
        $customer->save();
    }

    // Update idFinance di tabel sales
    $sale->idFinance = $finance->idFinance;
    $sale->save();

    // Notifikasi
    $notification = [
        'message' => 'Cicilan berhasil diperbarui .',
        'alert-type' => 'success'
    ];

    return redirect()->route('reports.customer')->with($notification);
}






}