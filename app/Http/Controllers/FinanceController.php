<?php

namespace App\Http\Controllers;

use App\Models\Finance;
use App\Models\MoneyOut;
use App\Models\User;
use App\Models\Sale;
use App\Models\Purchasing;
use App\Models\Service;
use App\Models\Product;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class FinanceController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->input('filter', 'harian');
        $date = $request->input('date', date('Y-m-d'));

        $query = Finance::with(['purchasings', 'sales']);

        switch ($filter) {
            case 'harian':
                $query->whereDate('tanggal', $date);
                break;
            case 'mingguan':
                $carbonDate = \Carbon\Carbon::parse($date);
                $query->whereBetween('tanggal', [$carbonDate->startOfWeek(), $carbonDate->endOfWeek()]);
                break;
            case 'bulanan':
                $carbonDate = \Carbon\Carbon::parse($date);
                $query->whereYear('tanggal', $carbonDate->year)->whereMonth('tanggal', $carbonDate->month);
                break;
            case 'tahunan':
                $carbonDate = \Carbon\Carbon::parse($date);
                $query->whereYear('tanggal', $carbonDate->year);
                break;
            default:
                $query->whereDate('tanggal', $date);
                break;
        }

        $finances = $query->paginate(10)->withQueryString();

        $totalModal = $query->sum('modal');
        $totalKeuntungan = $query->sum('keuntungan');
        $totalDana = $totalModal + $totalKeuntungan;

        return view('finances.index', compact('finances', 'totalModal', 'totalKeuntungan', 'totalDana', 'filter', 'date'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:0',
            'tanggal' => 'required|date',
        ]);

        try {
            Finance::create([
                'dana' => -$request->jumlah,
                // 'modal' => $request->jumlah,
                'keuntungan' => -$request->jumlah,

                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            MoneyOut::create([
                'keterangan' => $request->keterangan,
                'jumlah' => $request->jumlah,
                'tanggal' => $request->tanggal,
            ]);

            $notification = [
                'message' => 'Data dana keluar berhasil disimpan.',
                'alert-type' => 'success',
            ];
        } catch (\Exception $e) {
            Log::error('Store Dana Keluar Gagal: ' . $e->getMessage());
            $notification = [
                'message' => 'Gagal menyimpan data dana keluar.',
                'alert-type' => 'error',
            ];
        }

        return redirect()->back()->with($notification);
    }

    public function storee(Request $request)
    {
        $request->validate([
            'keterangan' => 'required|string|max:50',
            'jumlah' => 'required|integer|min:0',
            'tanggal' => 'required|date',
        ]);

        try {
            Finance::create([
                'dana' => $request->jumlah,
                'modal' => $request->jumlah,
                'tanggal' => $request->tanggal,
                'keterangan' => $request->keterangan,
            ]);

            $notification = [
                'message' => 'Dana masuk berhasil disimpan.',
                'alert-type' => 'success',
            ];
        } catch (\Exception $e) {
            Log::error('Store Dana Masuk Gagal: ' . $e->getMessage());
            $notification = [
                'message' => 'Gagal menyimpan data dana masuk.',
                'alert-type' => 'error',
            ];
        }

        return redirect()->back()->with($notification);
    }

    public function exportPDF(Request $request)
    {
        $filter = $request->get('filter', 'harian');
        $date = $request->get('date', now()->format('Y-m-d'));

        $query = Finance::with(['sales', 'purchasings', 'services']);

        switch ($filter) {
            case 'harian':
                $query->whereDate('tanggal', $date);
                break;
            case 'mingguan':
                $query->whereBetween('tanggal', [
                    Carbon::parse($date)->startOfWeek(),
                    Carbon::parse($date)->endOfWeek()
                ]);
                break;
            case 'bulanan':
                $query->whereMonth('tanggal', Carbon::parse($date)->month)
                      ->whereYear('tanggal', Carbon::parse($date)->year);
                break;
            case 'tahunan':
                $query->whereYear('tanggal', Carbon::parse($date)->year);
                break;
        }

        try {
            $finances = $query->get();
            $totalModal = $finances->sum('modal');
            $totalKeuntungan = $finances->sum('keuntungan');
            $totalDana = $finances->sum('dana');

            $pdf = Pdf::loadView('finances.finance_pdf', [
                'finances' => $finances,
                'totalModal' => $totalModal,
                'totalKeuntungan' => $totalKeuntungan,
                'totalDana' => $totalDana,
                'filter' => $filter,
                'date' => $date
            ])->setPaper('a4', 'landscape');

              return $pdf->stream('laporan_keuangan.pdf');
        } catch (Exception $e) {
            Log::error('Export PDF Gagal: ' . $e->getMessage());
            return redirect()->back()->with([
                'message' => 'Gagal mengekspor laporan ke PDF.',
                'alert-type' => 'error',
            ]);
        }
    }

    public function destroy(Finance $finance)
    {
        try {
            $finance->delete();
            $notification = [
                'message' => 'Data finance berhasil dihapus.',
                'alert-type' => 'success',
            ];
        } catch (\Exception $e) {
            Log::error('Hapus Data Finance Gagal: ' . $e->getMessage());
            $notification = [
                'message' => 'Gagal menghapus data finance.',
                'alert-type' => 'error',
            ];
        }

        return redirect()->route('finances.index')->with($notification);
    }
}
