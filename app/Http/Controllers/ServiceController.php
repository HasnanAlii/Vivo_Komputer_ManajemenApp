<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::with(['customer'])->paginate(8);
        return view('services.index', compact('services'));
    }

    
     public function indexx(Request $request)
    {
       $query = Service::with(['customer', 'products']);

    // Filter opsional
    if ($request->filter == 'today') {
        $query->whereDate('tglMasuk', \Carbon\Carbon::today());
    } elseif ($request->filter == 'week') {
        $query->whereBetween('tglMasuk', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($request->filter == 'month') {
        $query->whereMonth('tglMasuk', now()->month);
    } elseif ($request->filter == 'year') {
        $query->whereYear('tglMasuk', now()->year);
    }

    $services = $query->paginate(8);

        return view('reports.service', compact('services'));
    }

    public function create()
    {
        $products = Product::where('idCategory', 1)->get();
        return view('services.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'noTelp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'jenisPerangkat' => 'required|string|max:50',
            'kerusakan' => 'nullable|string|max:50',
            'idProduct' => 'nullable|array',
            'idProduct.*' => 'exists:products,idProduct',
            'biayaJasa' => 'nullable|integer|min:0',
        ]);

        $customer = Customer::create([
            'nama' => $request->nama,
            'noTelp' => $request->noTelp,
            'alamat' => $request->alamat,
        ]);

        // Hitung total modal sparepart
        $modal = 0;
        $usedProducts = [];

        if ($request->filled('idProduct')) {
            $products = Product::whereIn('idProduct', $request->idProduct)->get();

            foreach ($request->idProduct as $productId) {
                $product = $products->where('idProduct', $productId)->first();

                if ($product) {
                    if ($product->jumlah > 0) {
                        $product->jumlah -= 1;
                        $product->save();
                        $modal += $product->hargaBeli;
                        $usedProducts[] = $productId;
                    } else {
                        return back()->withErrors(['idProduct' => "Stok produk '{$product->namaBarang}' habis."]);
                    }
                }
            }
        }

        $biayaJasa = $request->biayaJasa ?? 0;
        $totalHarga = $modal + $biayaJasa;
        $keuntungan = $totalHarga - $modal;

       Service::create([
            'nomorFaktur' => rand(10000000, 99999999),
            'kerusakan' => $request->kerusakan,
            'jenisPerangkat' => $request->jenisPerangkat,
            'status' => false,
            'biayaJasa' => $biayaJasa,
            'totalHarga' => $totalHarga,
            'keuntungan' => $keuntungan,
            'tglMasuk' => Carbon::now(),
            'tglSelesai' => null,
            'idCustomer' => $customer->idCustomer,
            'idProduct' => count($usedProducts) ? implode(',', $usedProducts) : null,
            'idFinance' => null,
        ]);

        return redirect()->route('service.index')->with('success', 'Data service berhasil disimpan.');
    }

    public function edit($id)
    {
        $service = Service::findOrFail($id);
        $products = Product::where('idCategory', 1)->get();
        return view('services.update', compact('service', 'products'));
    }

    public function update(Request $request, $id)
    {
        $service = Service::findOrFail($id);

        $request->validate([
            'kerusakan' => 'required|string|max:50',
            'status' => 'required|boolean',
            'biayaJasa' => 'nullable|integer|min:0',
            'idProduct' => 'nullable|array',
            'idProduct.*' => 'exists:products,idProduct',
        ]);

        $modal = 0;
        $usedProducts = [];

        if ($request->filled('idProduct')) {
            $products = Product::whereIn('idProduct', $request->idProduct)->get();

            foreach ($request->idProduct as $productId) {
                $product = $products->where('idProduct', $productId)->first();

                if ($product) {
                    if ($product->jumlah > 0) {
                        $product->jumlah -= 1;
                        $product->save();
                        $modal += $product->hargaBeli;
                        $usedProducts[] = $productId;
                    } else {
                        return back()->withErrors(['idProduct' => "Stok produk '{$product->namaBarang}' habis."]);
                    }
                }
            }
        }

        $biayaJasa = $request->biayaJasa ?? 0;
        $totalHarga = $modal + $biayaJasa;
        $keuntungan = $totalHarga - $modal;

        $finance = Finance::create([
            'dana' => $totalHarga,
            'modal' => $modal,
            'totalDana' => $totalHarga,
            'tanggal' => now(),
            'keuntungan' => $keuntungan,
            'keterangan' => 'servis',
        ]);

        $service->kerusakan = $request->kerusakan;
        $service->status = $request->status;
        $service->biayaJasa = $biayaJasa;
        $service->totalHarga = $totalHarga;
        $service->keuntungan = $keuntungan;
        $service->idProduct = count($usedProducts) ? implode(',', $usedProducts) : null;
        $service->idFinance = $finance->idFinance;
        $service->tglSelesai = $request->status ? now() : null;
        $service->save();

        return redirect()->route('service.index')->with('success', 'Data service berhasil diperbarui dan stok produk dikurangi.');
    }
}
