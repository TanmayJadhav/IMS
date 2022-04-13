<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shopadmin extends Model
{
    use HasFactory,
    SoftDeletes;

    protected $fillable = [
        'shopname',
         'shopcategory_id',
         'ownername',
         'mobile',
         'address',
         'city',
         'state',
         'image_ext',
         'signature_image_ext',
         'password',
         'permission',
         'shopcategory',
         'created_at',
         'updated_at',
         'deleted_at'
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
    public function shopcategory()
    {
        return $this->belongsTo(Shopcategory::class);
    }
}
