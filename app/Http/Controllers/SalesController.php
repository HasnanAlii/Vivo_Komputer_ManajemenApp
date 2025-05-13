<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class SalesController extends Controller
{
    public function index()
{
    $sales = Sale::all(); // Atau bisa menggunakan pagination: Sales::paginate(10);
    return view('sales.index', compact('sales'));
}

}
