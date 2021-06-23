<?php

namespace App\PaymentProcessor\Concerns;

use App\Models\Payment;

use App\Http\Controllers\Controller;


use App\PaymentProcessor\Facades\FlutterwavePayment;
class PaymentHandler extends Controller
{

    /**
     * Redirect the User to Payment Gateway Page
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public static function redirectToGateway(array $params)
    {
        // Create Payment Record in the database before instantiating request
        $payment = \App\PaymentProcessor\Traits\CreatePayment::init($params['amount'], $params['payment_channel'], $params['payment_for'], $params['unique_id'], $params['return_route_name'], $params['meta_data']);

        // Determine payment channel
        if ($payment['payment_channel'] == Payment::PAYMENT_CHANNEL['paystack']) {
            return \App\PaymentProcessor\Facades\PaystackPayment::makePaymentRequest($payment);
        } elseif ($payment['payment_channel'] == Payment::PAYMENT_CHANNEL['flutterwave']) {
//            dd($payment);
            return FlutterwavePayment::makePaymentRequest($payment);
        } elseif ($payment['payment_channel'] == Payment::PAYMENT_CHANNEL['offline']) {
            // determine how to handle offline
        } elseif ($payment['payment_channel'] == Payment::PAYMENT_CHANNEL['wallet']) {
            // determine how to handle wallet payment
        } elseif ($payment['payment_channel'] == Payment::PAYMENT_CHANNEL['loyalty']) {
            # determine how to hanlde loyalty payment
        } else {
            \Illuminate\Support\Facades\Log::alert(request()->user()->id . 'attempted payment using a wrong payment channel', [
                'id' => request()->user()->id,
                'ip_address' => request()->ip(),
                'url' => request()->fullUrl()
            ]);
            return abort('403', 'UNABLE TO DETERMINE PAYMENT CHANNEL');
        }
    }
}
