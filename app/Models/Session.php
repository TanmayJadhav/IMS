<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'selling_price',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

}
