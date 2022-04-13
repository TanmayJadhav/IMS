<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productcategory extends Model
{
    use HasFactory;

    protected $table = 'product_categories';

    protected $fillable = [
        'name',
        'shopadmin_id',
        'shop_type'
    ];

    public function shopadmin()
    {
        return $this->belongsTo(Shopadmin::class);
    }
}
