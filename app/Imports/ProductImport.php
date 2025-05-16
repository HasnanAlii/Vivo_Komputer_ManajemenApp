<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'namaBarang'  => $row['namabarang'],
            'jumlah'      => $row['jumlah'],
            'hargaBeli'   => $row['hargabeli'],
            'hargaJual'   => $row['hargajual'],
            'idCategory'  => $row['idcategory'], 
        ]);
    }
}
