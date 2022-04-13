<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expense extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['date'];

    protected $fillable = [
        'date',
        'reason_id',
        'amount',
        'deleted_at',
        'shopadmin_id',
        'shop_type'
    ];

    public function reason()
    {
        return $this->belongsTo(Reason::class);
    }   
}
