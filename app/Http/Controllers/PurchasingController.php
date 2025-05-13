<?php

namespace App\Http\Controllers;

use App\Models\Purchase;
use Illuminate\Http\Request;

class PurchasingController extends Controller
{
    public function index()
{
    $purchasings = Purchase::all();
    return view('purchasing.index', compact('purchasings'));
}

}
