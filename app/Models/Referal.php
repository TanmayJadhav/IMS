<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Referal extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'shopadmin_id',
        'shop_type',
        'deleted_at'
        
    ];
}
