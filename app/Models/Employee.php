<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable = [
        'user_id',
        'name',
        'mobile',
        'salary',
        'salary_remaining',
        'deleted_at',
        'shopadmin_id',
        'shop_type'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
