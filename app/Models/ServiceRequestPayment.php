<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ServiceRequestPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'payment_id', 'service_request_id', 'amount', 'unique_id', 'payment_type', 'status'
    ];

    // protected static function booted()
    // {
    //     static::creating(function ($service_request_payment) {
    //         $service_request_payment->uuid = (string) Str::uuid(); 
    //     });
    // }


    public function service_request()
     {
         return $this->belongsTo(ServiceRequest::class);
     }

    public function clients()
    {
        return $this->belongsTo(User::class, 'user_id')->with('roles', 'account');
    }
}
