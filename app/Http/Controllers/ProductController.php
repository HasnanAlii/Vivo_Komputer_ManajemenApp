<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('category')->orderBy('namaBarang')->paginate(5);
        return view('products.index', compact('products'));
    }


    public function create()
    {
         $categories = Category::orderBy('namaKategori')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
           'namaBarang' => 'required|max:50',
            'jumlah' => 'required|integer',
            'hargaBeli' => 'required|integer',
            'hargaJual' => 'required|integer',
            'idCategory' => 'required|exists:categories,idCategory',
        ]);

        Product::create($request->all());

        return redirect()->route('product.index');
        
    }
    

    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    
    public function editt(Product $product)
    {
        return view('products.edit2', compact('product'));
    }
    public function updatee(Request $request, Product $product)
    {
        $request->validate([
           
            'hargaJual' => 'required|integer',
        ]);

        $product->update($request->all());

        return redirect()->route('sales.index');
    }
    
  

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'namaBarang' => 'required|max:50',
          
            'jumlah' => 'required|integer',
           
            'hargaJual' => 'required|integer',
        ]);

        $product->update($request->all());

        return redirect()->route('product.index');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('product.index');
    }
    public function import(Request $request)
{
    $request->validate([
        'file' => 'required|file|mimes:xlsx,xls'
    ]);

    Excel::import(new ProductImport, $request->file('file'));

    return redirect()->route('product.index')->with('success', 'Produk berhasil diimpor.');
}
}
