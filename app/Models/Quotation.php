<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use PhpParser\Node\Expr\FuncCall;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'client_id',
        'gst',
        'labour_charge',
        'transportation_charge',
        'total_price',
        'remaining_amount',
        'created_at',
        'updated_at',
        'deleted_at',
        'shop_type'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
