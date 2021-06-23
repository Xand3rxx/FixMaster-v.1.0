<?php
namespace App\PaymentProcessor\Facades;

use Illuminate\Support\Facades\Facade;

class FlutterwavePayment extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'flutterwave_payment';
    }
}