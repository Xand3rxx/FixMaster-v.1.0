<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'information', 'keyword', 'status'];

    /** 
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($paymentGateway) {
            $paymentGateway->uuid = (string) Str::uuid(); // Create uuid when a new payment gateway is to be created
        });
    }

    public function convertAutoData(){
        return json_decode($this->information,true);
    }

}
