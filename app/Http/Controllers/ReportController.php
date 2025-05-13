<?php

namespace App\Http\Controllers;

use App\Models\Report;
use App\Models\Sale;
use App\Models\Purchasing;
use App\Models\Service;
use App\Models\Finance;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index()
    {
        $reports = Report::all();
        return view('reports.index', compact('reports'));
    }

    public function create()
    {
        $sales = Sale::all();
        $purchasings = Purchasing::all();
        $services = Service::all();
        $finances = Finance::all();

        return view('reports.create', compact('sales', 'purchasings', 'services', 'finances'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenisLaporan' => 'required|in:harian,mingguan,bulanan,tahunan',
            'idSale' => 'nullable|exists:sales,idSale',
            'idPurchasing' => 'nullable|exists:purchasings,idPurchasing',
            'idService' => 'nullable|exists:services,idService',
            'idFinance' => 'nullable|exists:finance,idFinance',
        ]);

        Report::create($request->all());

        return redirect()->route('reports.index')->with('success', 'Report created successfully.');
    }

    public function edit(Report $report)
    {
        $sales = Sale::all();
        $purchasings = Purchasing::all();
        $services = Service::all();
        $finances = Finance::all();

        return view('reports.edit', compact('report', 'sales', 'purchasings', 'services', 'finances'));
    }

    public function update(Request $request, Report $report)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'jenisLaporan' => 'required|in:harian,mingguan,bulanan,tahunan',
            'idSale' => 'nullable|exists:sales,idSale',
            'idPurchasing' => 'nullable|exists:purchasings,idPurchasing',
            'idService' => 'nullable|exists:services,idService',
            'idFinance' => 'nullable|exists:finance,idFinance',
        ]);

        $report->update($request->all());

        return redirect()->route('reports.index')->with('success', 'Report updated successfully.');
    }

    public function destroy(Report $report)
    {
        $report->delete();

        return redirect()->route('reports.index')->with('success', 'Report deleted successfully.');
    }
}
