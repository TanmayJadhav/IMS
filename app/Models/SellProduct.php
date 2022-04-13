<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SellProduct extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sell_products';

    protected $fillable = [
        'receipt_id',
        'product_id',
        'quantity',
        'selling_price',
        'created_at',
        'updated_at',
        'deleted_at',
        'shop_type',
        'referal_name'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }
}
