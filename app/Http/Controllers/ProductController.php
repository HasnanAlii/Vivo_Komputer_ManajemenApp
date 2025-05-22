<?php

namespace App\Http\Controllers;

use App\Imports\ProductImport;
use App\Models\Category;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ProductController extends Controller
{
public function index(Request $request)
{
    $query = Product::query();

    // Filter kategori jika dipilih
    if ($request->filled('category')) {
        $query->where('idCategory', $request->category);
    }

    // Pencarian nama barang
    if ($request->filled('namaBarang')) {
        $query->where('namaBarang', 'like', '%' . $request->namaBarang . '%');
    }

    $products = $query->orderBy('namaBarang')->paginate(10);
    $categories = Category::all();

    return view('products.index', compact('products', 'categories'));
}

    public function create()
    {
        $categories = Category::orderBy('namaKategori')->get();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
         $request->merge([
        'hargaBeli' => str_replace('.', '', $request->hargaBeli),
        'hargaJual' => str_replace('.', '', $request->hargaJual),
        'jumlah' => str_replace('.', '', $request->jumlah),
    ]);
        $request->validate([
            'namaBarang' => 'required|max:50',
            'jumlah' => 'required|integer',
            'hargaBeli' => 'required|integer',
            'hargaJual' => 'required|integer',
            'idCategory' => 'required|exists:categories,idCategory',
        ]);

        try {
            Product::create($request->all());
            $notification = [
                'message' => 'Penambahan produk berhasil dilakukan',
                'alert-type' => 'success'
            ];
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Gagal menambahkan produk: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('product.index')->with($notification);
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

        try {
            $product->update($request->all());
            $notification = [
                'message' => 'Harga jual produk berhasil diperbarui',
                'alert-type' => 'success'
            ];
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Gagal memperbarui harga: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('sales.index')->with($notification);
    }

    public function update(Request $request, Product $product)
    {
         $request->merge([
        'hargaJual' => str_replace('.', '', $request->hargaJual),
        'jumlah' => str_replace('.', '', $request->jumlah),
    ]);
        $request->validate([
            'namaBarang' => 'required|max:50',
            'jumlah' => 'required|integer',
            'hargaJual' => 'required|integer',
        ]);

        try {
            $product->update($request->all());
            $notification = [
                'message' => 'Produk berhasil diperbarui',
                'alert-type' => 'success'
            ];
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Gagal memperbarui produk: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('product.index')->with($notification);
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();
            $notification = [
                'message' => 'Produk berhasil dihapus',
                'alert-type' => 'success'
            ];
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Gagal menghapus produk: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('product.index')->with($notification);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls'
        ]);

        try {
            Excel::import(new ProductImport, $request->file('file'));
            $notification = [
                'message' => 'Produk berhasil diimpor',
                'alert-type' => 'success'
            ];
        } catch (\Exception $e) {
            $notification = [
                'message' => 'Gagal mengimpor produk: ' . $e->getMessage(),
                'alert-type' => 'error'
            ];
        }

        return redirect()->route('product.index')->with($notification);
    }
     
}
