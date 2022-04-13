<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Operator extends Model
{
    use HasFactory,SoftDeletes;


    protected $fillable = [
        'shopadmin_id',
        'name',
        'mobile',
        'password',
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
