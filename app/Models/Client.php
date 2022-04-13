<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'shopadmin_id',
         'name',
         'mobile',
         'address',
         'amount_remaining',
         'created_at',
         'updated_at',
         'deleted_at',
         'shop_type'
    ];

    public function shopadmin()
    {
        return $this->belongsTo(Shopadmin::class);
    }
}
