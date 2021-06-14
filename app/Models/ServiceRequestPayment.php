<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'payment_id', 'service_request_id', 'amount', 'unique_id', 'payment_type', 'status'
    ];
}
