<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Finance;
use App\Models\Pembayaran;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class CustomerController extends Controller
{
public function index()
{
    // Pastikan eager load semua relasi yang dibutuhkan
    $customers = Customer::with(['sales.product', 'purchasings', 'services'])->get();

    foreach ($customers as $customer) {
        // Sum harga jual dari produk penjualan
        $totalSales = $customer->sales->sum(function ($sale) {
            return $sale->product->hargaJual ?? 0;
        });

        // Sum total harga beli dari pembelian
        $totalPurchases = $customer->purchasings->sum('hargaBeli');

        // Sum biaya dari service
        $totalServiceCost = $customer->services->sum('biaya');

        // Total transaksi gabungan
        $customer->totalTransaksi = $totalSales + $totalPurchases + $totalServiceCost;
    }

    return view('customers.index', compact('customers'));
}



    public function create()
    {
        return view('sales.tambah');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:50',
            'alamat' => 'required|string|max:100',
            'noTelp' => 'required|string|max:15',
        ]);
        $notification = [
        'message' => 'Data Customer Disimpan.',
        'alert-type' => 'success'
    ];
        Customer::create($request->all());
        return redirect()->route('sales.index')->with($notification);
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

public function cetakhutang($id)
{
    $customer = Customer::with(['sales.product', 'pembayaran'])->findOrFail($id);

    return view('reports.cetakhutang', compact('customer'));
}

public function updateCicilan(Request $request, $idCustomer)
{
       $request->merge([
        'cicilan' => str_replace('.', '', $request->cicilan),
    ]);

    $request->validate([
        'cicilan' => 'required|numeric|min:1',
    ]);

    $customer = Customer::with(['sales.product', 'pembayaran'])->findOrFail($idCustomer);
    $jumlahBayar = (int) $request->cicilan;

    // Hitung sisa cicilan
    $lastPembayaran = $customer->pembayaran()->latest()->first();
    $currentSisa = $lastPembayaran?->sisaCicilan ?? $customer->cicilan;
    $sisaCicilan = $currentSisa - $jumlahBayar;

    if ($sisaCicilan < 0) {
        return redirect()->back()->with([
            'message' => 'Jumlah pembayaran melebihi sisa cicilan.',
            'alert-type' => 'error'
        ]);
    }

    // Ambil transaksi penjualan terakhir
    $sale = Sale::where('idCustomer', $idCustomer)->latest()->first();
    if (!$sale) {
        return redirect()->back()->with([
            'message' => 'Data penjualan tidak ditemukan.',
            'alert-type' => 'error'
        ]);
    }

    $totalModal = 0;
    $totalKeuntungan = 0;

    // Simpan pembayaran terlebih dahulu
    $pembayaran = new Pembayaran();
    $pembayaran->idCustomer = $customer->idCustomer;
    $pembayaran->idShopping = $sale->idShopping ?? null;
    $pembayaran->tanggalBayar = now();
    $pembayaran->bayar = $jumlahBayar;
    $pembayaran->sisaCicilan = $sisaCicilan;
    $pembayaran->save();

    // Simpan keuangan
    $finance = new Finance();
    $finance->dana = $jumlahBayar;
    $finance->sisa_cicilan = $sisaCicilan;
    $finance->tanggal = now()->toDateString();
    $finance->keterangan = 'Pembayaran cicilan oleh ' . $customer->nama;

    if ($sisaCicilan == 0) {
        $allSales = Sale::where('idCustomer', $customer->idCustomer)->get();

        foreach ($allSales as $s) {
            $modalProduk = $s->product->hargaBeli ?? 0;
            $totalHarga = $s->hargaTransaksi * $s->jumlah;
            $modal = $modalProduk * $s->jumlah;
            $untung = $totalHarga - $modal;

            $s->keuntungan = $untung;
            $s->jenisPembayaran = 'lunas';

            $s->idFinance = $finance->idFinance ?? null;
            $s->save();

            $totalModal += $modal;
            $totalKeuntungan += $untung;
        }

        $finance->modal = $totalModal;
        $finance->keuntungan = $totalKeuntungan;
    } else {
        $finance->modal = 0;
        $finance->keuntungan = 0;
    }

    $finance->totalDana = $jumlahBayar;
    $finance->save();

    // Simpan ID finance
    if (Schema::hasColumn('customers', 'idFinance')) {
        $customer->idFinance = $finance->idFinance;
    }

    // Update cicilan
    if ($sisaCicilan == 0) {
        $customer->cicilan = 0;
    }
    $customer->save();

    if ($sisaCicilan == 0) {
        foreach ($allSales as $s) {
            $s->idFinance = $finance->idFinance;
            $s->save();
        }

        // Hapus semua riwayat pembayaran sebelumnya (reset bayar jadi 0)
        Pembayaran::where('idCustomer', $customer->idCustomer)
            ->update(['bayar' => 0]);
    } else {
        $sale->idFinance = $finance->idFinance;
        $sale->save();
    }

    $pembayaran->idFinance = $finance->idFinance;
    $pembayaran->save();

    // Redirect ke halaman cetak setelah pembayaran
    return redirect()->route('reports.cetakhutang', $customer->idCustomer)->with([
        'message' => 'Cicilan berhasil dibayarkan dan siap dicetak.',
        'alert-type' => 'success'
    ]);
}


}