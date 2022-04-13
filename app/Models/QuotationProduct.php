<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationProduct extends Model
{
    use HasFactory;

    protected $table = 'quotation_products';

    protected $fillable = [
        'quotation_id',
         'product_id',
         'quantity',
         'selling_price',
         'created_at',
         'updated_at',
         'deleted_at'
    ];
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
