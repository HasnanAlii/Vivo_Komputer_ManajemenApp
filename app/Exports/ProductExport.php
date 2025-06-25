<?php
namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Product::with('category')->get()->map(function ($product) {
            return [
                'Nama Barang' => $product->namaBarang,
                'Jumlah' => $product->jumlah,
                'Harga Beli' => $product->hargaBeli,
                'Harga Jual' => $product->hargaJual,
                'idCategory' => $product->category->idCategory,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Barang',
            'Jumlah',
            'Harga Beli',
            'Harga Jual',
            'idCategory',
        ];
    }
}
