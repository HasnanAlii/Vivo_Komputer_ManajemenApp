<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\Pembayaran;
use App\Models\Shopping;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
  public function index()
    {
        // Pastikan eager load relasi cicilanTerakhir dan pembayarans (kalau dipakai di view)
        $shoppings = Shopping::with(['cicilanTerakhir', 'pembayaranCicilan'])->get();

        return view('reports.shopping', compact('shoppings'));
    }
    public function create()
    {
        return view('reports.tambahshooping');
    }
    public function destroy($id)
{
    // Cari data shopping
    $shopping = Shopping::findOrFail($id);

    // Hapus semua pembayaran cicilan yang terkait
    $shopping->pembayaran()->delete();

    // Hapus data shopping
    $shopping->delete();

   return redirect()->route('reports.shopping')->with([
        'message' => 'Data berhasil dihapus',
        'alert-type' => 'success',
    ]);

}


 public function store(Request $request)
{
    // Hapus format ribuan
    $request->merge([
        'totalbelanja' => str_replace('.', '', $request->totalbelanja),
        'jumlah' => str_replace('.', '', $request->jumlah),
    ]);

    // Validasi input
    $request->validate([
        'sumber' => 'required|string|max:255',
        'jumlah' => 'required|integer|min:1',
        'totalbelanja' => 'required|integer|min:0',
    ]);

    // Status lunas berdasarkan centang
    $isLunas = $request->has('statuspembayaran');
    $total = (int) $request->totalbelanja;

    // Simpan keuangan
    $finance = Finance::create([
        'dana' => $total,
        'modal' => $isLunas ? -$total : 0,
        'keuntungan' => 0,
        'totalDana' => $total,
        'tanggal' => now()->toDateString(),
        'keterangan' => ($isLunas ? 'Pembayaran belanja dari ' : 'Belanja dari ') . $request->sumber,
    ]);

    // Simpan belanja
    $shopping = Shopping::create([
        'sumber' => $request->sumber,
        'jumlah' => $request->jumlah,
        'statuspembayaran' => $isLunas,
        'totalbelanja' => $total,
        'idFinance' => $finance->idFinance,
    ]);

    // Jika belum lunas, simpan cicilan awal
    if (!$isLunas) {
        Pembayaran::create([
            'bayar' => 0,
            'sisaCicilan' => $total,
            'tanggalBayar' => now()->toDateString(),
            'idShopping' => $shopping->id,
        ]);
    }

    return redirect()->route('reports.shopping')->with([
        'message' => 'Data berhasil ditambahkan',
        'alert-type' => 'success',
    ]);
}



    public function show(Shopping $shopping)
    {
        return view('shopping.show', compact('shopping'));
    }

    public function edit(Shopping $shopping)
    {
        return view('reports.editshooping', compact('shopping'));
    }

 public function update(Request $request, Shopping $shopping)
{
    // Bersihkan format ribuan
    $request->merge([
        'bayar' => str_replace('.', '', $request->bayar),
    ]);

    $request->validate([
        'bayar' => 'nullable|integer|min:0',
        'tanggalBayar' => 'nullable|date',
    ]);

    $total = (int) $request->totalbelanja;
    $bayar = (int) $request->bayar;

    // Ambil pembayaran terakhir untuk hitung sisa cicilan
    $lastPembayaran = $shopping->pembayaran()->latest()->first();

    // Jika belum ada pembayaran, sisa cicilan awal = total belanja
    $currentSisa = $lastPembayaran ? $lastPembayaran->sisaCicilan : $total;

    // Hitung sisa cicilan setelah pembayaran baru
    $sisaCicilan = $currentSisa - $bayar;

    // Validasi agar tidak melebihi sisa cicilan
    if ($sisaCicilan < 0) {
        return redirect()->back()->with('error', 'Jumlah pembayaran melebihi sisa cicilan.');
    }

    // Status lunas jika sisa cicilan = 0
    $statusLunas = $sisaCicilan == 0;

    // Update total belanja dan status pembayaran
    $shopping->update([
        'statuspembayaran' => $statusLunas,
    ]);

    // Simpan pembayaran baru jika bayar > 0
    if ($bayar > 0) {
        $pembayaran = Pembayaran::create([
            'bayar' => $bayar,
            'sisaCicilan' => $sisaCicilan,
            'idShopping' => $shopping->id,
        ]);
    }

    // Jika lunas dan belum tercatat di finance, buat finance baru
    if ($statusLunas && !$shopping->idFinance) {
        $finance = new Finance();
        $finance->dana = $total;
        $finance->modal = -$total;
        $finance->keuntungan = 0;
        $finance->totalDana = $total;
        $finance->tanggal = now()->toDateString();
        $finance->keterangan = 'Pembayaran belanja dari ' . $shopping->sumber;
        $finance->save();

        $shopping->idFinance = $finance->idFinance;
        $shopping->save();

        // Update idFinance di pembayaran terbaru
        if (isset($pembayaran)) {
            $pembayaran->idFinance = $finance->idFinance;
            $pembayaran->save();
        }
    } elseif (isset($pembayaran)) {
        // Jika belum lunas, tetap update idFinance pembayaran dengan idFinance shopping (jika ada)
        $pembayaran->idFinance = $shopping->idFinance;
        $pembayaran->save();
    }

    return redirect()->route('reports.shopping')->with([
        'message' => 'Data perbelanjaan diperbaharui',
        'alert-type' => 'success',
    ]);
}


}
