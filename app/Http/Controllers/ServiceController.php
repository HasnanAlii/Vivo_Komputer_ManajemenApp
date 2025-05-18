<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
           $filter = $request->input('filter');

    $query = Service::with(['customer', 'products']);

    if ($filter) {
        if ($filter == 'harian') {
            $query->whereDate('tglMasuk', Carbon::today());
        } elseif ($filter == 'mingguan') {
            $query->whereBetween('tglMasuk', [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()]);
        } elseif ($filter == 'bulanan') {
            $query->whereYear('tglMasuk', Carbon::now()->year)
                  ->whereMonth('tglMasuk', Carbon::now()->month);
        }
    }

    $services = $query->orderBy('tglMasuk', 'desc')->paginate(8)->withQueryString();

    return view('services.index', compact('services'));
}
    public function indexx(Request $request)
    {
        $query = Service::with(['customer', 'products']);

        if ($request->filter == 'today') {
            $query->whereDate('tglMasuk', Carbon::today());
        } elseif ($request->filter == 'week') {
            $query->whereBetween('tglMasuk', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($request->filter == 'month') {
            $query->whereMonth('tglMasuk', now()->month);
        } elseif ($request->filter == 'year') {
            $query->whereYear('tglMasuk', now()->year);
        }

        $services = $query->paginate(8);
        $totalModal = $query->sum('totalHarga') - $query->sum('biayaJasa');
        $totalKeuntungan = $query->sum('biayaJasa');
        $totalPendapatan= $query->sum('totalHarga');

        return view('reports.service', compact('services' ,'totalModal', 'totalKeuntungan', 'totalPendapatan' ));
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

    try {
        $customer = Customer::create([
            'nama' => $request->nama,
            'noTelp' => $request->noTelp,
            'alamat' => $request->alamat,
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
                        return back()->withErrors(['idProduct' => "Stok produk '{$product->namaBarang}' habis."])
                                     ->withInput();
                    }
                }
            }
        }

        $biayaJasa = $request->biayaJasa ?? 0;
        $totalHarga = $modal + $biayaJasa;
        $keuntungan = $totalHarga - $modal;

        $service = Service::create([
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

        return redirect()->route('service.struk', ['id' => $service->idService])->with([
            'message' => 'Data service berhasil disimpan.',
            'alert-type' => 'success'
        ]);
    } catch (\Exception $e) {
        return back()->with([
            'message' => 'Gagal menyimpan data service: ' . $e->getMessage(),
            'alert-type' => 'error'
        ])->withInput();
    }
}


public function struk($id)
{
    $service = Service::with('customer')->findOrFail($id);

    // Jika perlu ambil detail produk berdasarkan ID di string
    $products = [];
    if ($service->idProduct) {
        $productIds = explode(',', $service->idProduct);
        $products = Product::whereIn('idProduct', $productIds)->get();
    }

    return view('services.struk', compact('service', 'products'));
}




public function update(Request $request, $id)
{
    $service = Service::findOrFail($id);
    $oldStatus = $service->status;

    $request->validate([
        'kerusakan' => 'required|string|max:50',
        'status' => 'required|boolean',
        'biayaJasa' => 'nullable|integer|min:0',
        'idProduct' => 'nullable|array',
        'idProduct.*' => 'exists:products,idProduct',
    ]);

    try {
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
                        return back()->withErrors(['idProduct' => "Stok produk '{$product->namaBarang}' habis."])
                                     ->withInput();
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

        
     if ($oldStatus == 0 && $request->status == 1) {
    $this->sendWhatsappNotification($service);
    
        return redirect()->route('service.struk', ['id' => $service->idService])->with([
        'message' => 'Pesan pemberitahuan berhasil terkirim dan data service diperbarui.',
        'alert-type' => 'success'
            ]);
        } else {
            return redirect()->route('service.index')->with([
                'message' => 'Data service berhasil diperbarui.',
                'alert-type' => 'success'
            ]);
        }


    } catch (\Exception $e) {
        return back()->with([
            'message' => 'Gagal memperbarui data service. ' . $e->getMessage(),
            'alert-type' => 'error'
        ])->withInput();
    }
}
private function sendWhatsappNotification($service)
{
    $customer = $service->customer; 
    $phone = $customer->noTelp;     
    $message = "Halo {$customer->nama}, service Anda dengan {$service->kerusakan} sudah SELESAI.\nSilakan datang ke toko untuk mengambil barang Anda.\nTerima kasih telah menggunakan layanan kami. 🙏";

  $response = Http::withHeaders([
    'Authorization' => 'L9PaGYokqbue5GHechJR',
])->post('https://api.fonnte.com/send', [
    'target' => $phone,
    'message' => $message,
    'countryCode' => '62',
]);

Log::info('Fonnte response:', $response->json());

}
 public function edit($id)
{
        $service = Service::findOrFail($id);
        $products = Product::where('idCategory', 1)->get();
        return view('services.update', compact('service', 'products'));
}

  
}
