<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToModel, WithStartRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function startRow(): int
    {
        return 2;
    }
    public function model(array $row)
    {
        return new Product([
            'shop_id'     => $row[0],
            'shopadmin_id'    => $row[1],
            'vendor_id' => $row[2],
            'product_name' => $row[3],
            'product_category' => $row[4],
            'quantity' => $row[5],
            'brand' => $row[6],
            'model' => $row[7],
            'purchase_price' => $row[8],
            'selling_price' => $row[9],
            'tax_slab' => $row[10],
            'category' => $row[11],
            'type' => $row[12],
            'processor' => $row[13],
            'os' => $row[14],
            'ram' => $row[15],
            'display' => $row[16],
            'screen_size' => $row[17],
            'shortage' => $row[18],
            'basic_price' => $row[19],
            'selling_price' => $row[20],
            'manufacture_date' => $row[21],
            'expiry_date' => $row[22],
            'shop_type' => $row[23],
        ]);
    }
}
