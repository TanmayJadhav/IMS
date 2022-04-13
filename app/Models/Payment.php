<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['date'];

    protected $fillable = [
        'client_id',
        'amount_paid',
        'date',
        'employee_id',
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
