<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\PaymentProcessor\PaystackPayment;

class PaystackPaymentServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('paystack_payment', function () {

            return new PaystackPayment();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
