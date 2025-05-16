<?php

namespace App\Http\Controllers;

use App\Models\Finance; // jangan lupa import modelnya
use App\Models\Service;
use App\Models\Customer;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ServiceController extends Controller
{
    public function index()
    {
        // Lebih baik pakai paginate agar data tidak terlalu banyak sekaligus
        $services = Service::with(['customer', 'products', 'user'])->paginate(8);
        return view('services.index', compact('services'));
    }

    public function create()
    {
        // Jika ingin mengambil produk dengan kategori 1 (Sparepart/Perbaikan)
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
    'kerusakan' => 'nullable|string|max:255',  // ubah jadi nullable
    'idProduct' => 'nullable|exists:products,idProduct',
]);


        // Simpan customer dulu
        $customer = Customer::create([
            'nama' => $request->nama,
            'noTelp' => $request->noTelp,
            'alamat' => $request->alamat,
        ]);

        // Simpan service baru
        Service::create([
            'nomorFaktur' => $this->generateUniqueNomorFaktur(),
            'kerusakan' => $request->kerusakan,
            'jenisPerangkat' => $request->jenisPerangkat,
            'status' => false,
            'totalBiaya' => 0,
            'keuntungan' => 0,
            'tglMasuk' => Carbon::now(),
            'tglSelesai' => null,
            'idCustomer' => $customer->idCustomer,
            'idProduct' => $request->idProduct, // nullable sudah di-validate
            'idFinance' => null,
        ]);

        return redirect()->route('service.index')->with('success', 'Data service berhasil disimpan.');
    }

    // Generate nomor faktur unik
    private function generateUniqueNomorFaktur()
    {
        do {
            $nomorFaktur = rand(10000000, 99999999);
        } while (Service::where('nomorFaktur', $nomorFaktur)->exists());

        return $nomorFaktur;
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
        'kerusakan' => 'required|string|max:255',
        'status' => 'required|boolean',
        'totalBiaya' => 'required|numeric|min:0',
        'idProduct' => 'nullable|exists:products,idProduct',
    ]);

    $modal = 0;

    if ($request->filled('idProduct')) {
        $product = Product::find($request->idProduct);

        if ($product) {
            $modal = $product->hargaBeli;

            // Kurangi stok
            if ($product->jumlah > 0) {
                $product->jumlah -= 1;
                $product->save();
            } else {
                return back()->withErrors(['idProduct' => 'Stok produk habis.']);
            }
        }
    }

    $keuntungan = $request->totalBiaya - $modal;

    $finance = Finance::create([
        'dana' => $request->totalBiaya,
        'modal' => $modal,
        'totalDana' => $request->totalBiaya,
        'tanggal' => now(),
        'keuntungan' => $keuntungan,
        'keterangan' => 'servis',
    ]);

    $service->kerusakan = $request->kerusakan;
    $service->status = $request->status;
    $service->totalBiaya = $request->totalBiaya;
    $service->keuntungan = $keuntungan;
    $service->idProduct = $request->idProduct;
    $service->idFinance = $finance->idFinance;
    $service->tglSelesai = $request->status ? now() : null;
    $service->save();

    return redirect()->route('service.index')->with('success', 'Data service berhasil diperbarui dan stok produk dikurangi.');
}

}



