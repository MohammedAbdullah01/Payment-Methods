<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    protected $fillable = [
        'payment_method_id',
        'paymenttable_type',
        'paymenttable_id',
        'payer_type',
        'payer_id',
        'amount',
        'currency_code',
        'status',
        'transaction_id',
        'payment_response',
    ];

    protected $casts = [
        'payment_response' => 'json'
    ];
}
