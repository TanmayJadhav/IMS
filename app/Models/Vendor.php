<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'shopadmin_id',
         'name',
         'mobile',
         'product_category_id',
         'address',
         'created_at',
         'updated_at',
         'deleted_at',
         'shop_type'
    ];

    public function shopadmin()
    {
        return $this->belongsTo(Shopadmin::class);
    }
    public function product_category()
    {
        return $this->belongsTo(Productcategory::class);
    }
}
