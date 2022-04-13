<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'shop_id',
        'shopadmin_id',
         'vendor_id',
         'product_name',
         'product_category',
         'quantity',
         'brand',
         'model',
         'purchase_price',
         'selling_price',
         'tax_slab',
         'category',
         'type',
         'processor',
         'os',
         'ram',
         'display',
         'screen_size',
         'shortage',
         'purchase_gst',
         'basic_price',
         'warranty',
         'manufacturer',
         'manufacture_date',
         'expiry_date',
         'batch_no',
         'selling_gst',
         'shop_type'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class);
    }
    public function shopadmin()
    {
        return $this->belongsTo(Shopadmin::class);
    }
}
