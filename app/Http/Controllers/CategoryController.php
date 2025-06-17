<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Menampilkan semua kategori
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Tampilkan form tambah kategori
    public function create()
    {
        return view('categories.create');
    }

    // Simpan data kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'kodeKategori' => 'required|unique:categories,kodeKategori',
            'namaKategori' => 'required',
        ]);

        Category::create([
            'kodeKategori' => $request->kodeKategori,
            'namaKategori' => $request->namaKategori,
        ]);

        return redirect()->route('categories.index')->with([
            'message' => 'Data kategori berhasil disimpan.',
            'alert-type' => 'success'
        ]);
    }

    // Menampilkan detail kategori
    public function show(Category $category)
    {
        return view('categories.show', compact('category'));
    }

    // Tampilkan form edit kategori
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Update kategori
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'kodeKategori' => 'required|unique:categories,kodeKategori,' . $category->idCategory . ',idCategory',
            'namaKategori' => 'required',
        ]);

        $category->update([
            'kodeKategori' => $request->kodeKategori,
            'namaKategori' => $request->namaKategori,
        ]);

        return redirect()->route('categories.index')->with([
            'message' => 'Data kategori berhasil diperbarui.',
            'alert-type' => 'success'
        ]);
    }

    // Hapus kategori
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index')->with([
            'message' => 'Data kategori berhasil dihapus.',
            'alert-type' => 'success'
        ]);
    }
}
