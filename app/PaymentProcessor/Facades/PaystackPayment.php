<?php
namespace App\PaymentProcessor\Facades;

use Illuminate\Support\Facades\Facade;

class PaystackPayment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'paystack_payment';
    }
}