<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Service;
use App\Models\Customer;
use App\Models\Employee;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use Illuminate\Container\Attributes\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ServiceController extends Controller
{
public function index(Request $request)
{
    $query = Service::with(['customer', 'products']);

    // Filter berdasarkan waktu
    if ($request->filter === 'harian') {
        $query->whereDate('created_at', now());
    } elseif ($request->filter === 'mingguan') {
        $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    } elseif ($request->filter === 'bulanan') {
        $query->whereMonth('created_at', now()->month);
    }

    // Filter berdasarkan nomor faktur
    if ($request->filled('cari_faktur')) {
        $query->where('nomorFaktur', 'like', '%' . $request->cari_faktur . '%');
    }

    $services = $query->orderByDesc('created_at')->paginate(10);

    return view('services.index', compact('services'));
}

    public function indexx(Request $request)
{
    $filter = $request->input('filter', 'harian');
    $idEmployee = $request->input('idEmployee');
    $date = $request->input('date', \Carbon\Carbon::today()->toDateString());
    $carbonDate = \Carbon\Carbon::parse($date);

    // Query awal dengan eager loading relasi
    $query = Service::with(['customer', 'products', 'employee']);

    // Filter waktu
    switch ($filter) {
        case 'harian':
            $query->whereDate('tglMasuk', $carbonDate);
            break;
        case 'mingguan':
            $startOfWeek = $carbonDate->copy()->startOfWeek();
            $endOfWeek = $carbonDate->copy()->endOfWeek();
            $query->whereBetween('tglMasuk', [$startOfWeek, $endOfWeek]);
            break;
        case 'bulanan':
            $query->whereYear('tglMasuk', $carbonDate->year)
                  ->whereMonth('tglMasuk', $carbonDate->month);
            break;
        case 'tahunan':
            $query->whereYear('tglMasuk', $carbonDate->year);
            break;
    }

    if (!empty($idEmployee)) {
        $query->where('idEmployee', $idEmployee);
    }

    $totalQuery = clone $query;

    $services = $query->latest()->paginate(10)->withQueryString();

    $allData = $totalQuery->get();

    $totalModal = $allData->sum(function ($item) {
        return $item->products->sum('hargaBeli');
    });

    $totalKeuntungan = $allData->sum('biayaJasa');
    $totalPendapatan = $allData->sum('totalHarga');

    // Ambil daftar employee untuk filter
    $employees = Employee::all();

    return view('reports.service', compact(
        'services',
        'totalModal',
        'totalKeuntungan',
        'totalPendapatan',
        'employees',
        'filter',
        'idEmployee',
        'date'
    ));
}



    public function create()
    {
        $products = Product::where('idCategory', 1)->get();
        return view('services.create', compact('products'));
    }

         public function menu()
    {
            return view('services.menu');
       
    }
          public function createe()
        {
        $products = Product::where('idCategory', 1)->get();
        $customers = Customer::all(); 
        return view('services.create2', compact('products','customers'));  
        }




        
   public function store(Request $request)
{
    $request->validate([
        'nama' => 'required|string|max:255',
        'noTelp' => 'required|string|max:20',
        'alamat' => 'required|string|max:255',
        'jenisPerangkat' => 'required|string|max:255',
        'kondisi' => 'required|string|max:255',
        'ciriCiri' => 'nullable|string|max:255',
        'kelengkapan' => 'required|string|max:255',
        'kerusakan' => 'nullable|string|max:255',
    ]);

    try {
        $customer = Customer::create([
            'nama' => $request->nama,
            'noTelp' => $request->noTelp,
            'alamat' => $request->alamat,
        ]);


        $service = Service::create([
            'nomorFaktur' => rand(10000000, 99999999),
            'kerusakan' => $request->kerusakan,
            'jenisPerangkat' => $request->jenisPerangkat,
            'kondisi' => $request->kondisi,
            'ciriCiri' => $request->ciriCiri,
            'kelengkapan' => $request->kelengkapan,
            'status' => false,
            'tglMasuk' => Carbon::now(),
            'tglSelesai' => null,
            'idCustomer' => $customer->idCustomer,
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
public function storee(Request $request)
{
    $request->validate([
       'idCustomer' => 'required|exists:customers,idCustomer', 
        'jenisPerangkat' => 'required|string|max:255',
        'kondisi' => 'required|string|max:255',
        'ciriCiri' => 'nullable|string|max:255',
        'kelengkapan' => 'required|string|max:255',
        'kerusakan' => 'nullable|string|max:255',
        
    ]);

  

    try {
        // customer wajib ada, jadi langsung ambil
        $customer = Customer::findOrFail($request->idCustomer);


        $service = Service::create([
            'nomorFaktur' => rand(10000000, 99999999),
            'kerusakan' => $request->kerusakan,
            'jenisPerangkat' => $request->jenisPerangkat,
            'kondisi' => $request->kondisi,
            'ciriCiri' => $request->ciriCiri,
            'kelengkapan' => $request->kelengkapan,
            'status' => false,
            'tglMasuk' => Carbon::now(),
            'tglSelesai' => null,
            'idCustomer' => $customer->idCustomer,
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
        $productId = explode(',', $service->idProduct);
        $products = Product::whereIn('idProduct', $productId)->get();
    }

    return view('services.struk', compact('service', 'products'));
}
public function label($id)
{
    $service = Service::with('customer')->findOrFail($id);

    // Jika perlu ambil detail produk berdasarkan ID di string
    $products = [];
    if ($service->idProduct) {
        $productId = explode(',', $service->idProduct);
        $products = Product::whereIn('idProduct', $productId)->get();
    }

    return view('services.label', compact('service', 'products'));
}





public function update(Request $request, $id)
{
      $request->merge([
        'biayaJasa' => str_replace('.', '', $request->biayaJasa),
    ]);

    $service = Service::findOrFail($id);
    $oldStatus = $service->status;

    $request->validate([
        'kerusakan' => 'required|string|max:50',
        'status' => 'required|boolean',
        'biayaJasa' => 'nullable|integer|min:0',
        'keterangan' => 'nullable|string|max:50',   
        'idProduct' => 'nullable|array',
        'idProduct.*' => 'exists:products,idProduct',
        'jasa'=> 'nullable|string|max:50',
        'idEmployee' => 'exists:employess,idEmployee',
    ]);

    try {
        $modal = 0;
        $totalHargaProduk = 0;
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
                        $totalHargaProduk += $product->hargaJual;
                        $usedProducts[] = $productId;
                    } else {
                        return back()->withErrors(['idProduct' => "Stok produk '{$product->namaBarang}' habis."])
                                     ->withInput();
                    }
                }
            }
        }

        $biayaJasa = $request->biayaJasa ?? 0;
        $totalHarga = $totalHargaProduk + $biayaJasa;
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
        $service->keterangan = $request->keterangan;
        $service->status = $request->status;
        $service->biayaJasa = $biayaJasa;
        $service->jasa = $request->jasa;
        $service->idEmployee = $request->idEmployee;
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
    $message = "Halo {$customer->nama}, Saya dari Vivo Komputer,\nservice Anda dengan kerusakan {$service->kerusakan} sudah SELESAI dan Total biaya perbaikan senilai\nRP. " . number_format($service->totalHarga, 0, ',', '.')."\nSilakan datang ke toko untuk mengambil barang Anda.\nTerima kasih telah menggunakan layanan kami. 🙏";

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
         $employees = Employee::all();
        $products = Product::where('idCategory', 1)->get();
        return view('services.update', compact('service', 'products','employees'));
}

  
}
