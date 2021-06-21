<?php

namespace App\PaymentProcessor\Traits;

use App\Models\Payment;

trait CreatePayment
{
    /**
     * Create Payment record for transactions 
     * 
     * @param  int     $amount
     * @param  string  $payment_channel
     * @param  string  $payment_for
     * @param  string  $unique_id
     * @param  string  $route_name
     * @param  array   $meta_data
     * 
     * @return \App\Models\Payment
     */
    public static function init(int $amount, string $payment_channel, string $payment_for, string $unique_id, string $route_name, array $meta_data = [])
    {
        return self::creator($amount, $payment_channel, $payment_for, $unique_id, $route_name, $meta_data);
    }

    /**
     * Create Payment Record for Transaction to different payment channels
     *
     * @param  int          $amount
     * @param  string       $payment_channel
     * @param  string       $payment_for
     * @param  string       $unique_id
     * @param  string       $route_name
     * @param  array        $meta_data
     * 
     * @return \App\Models\Payment
     */
    protected static function creator(int $amount, string $payment_channel, string $payment_for, string $unique_id, string $route_name, array $meta_data = [])
    {
        return Payment::create([
            'amount'             => $amount,
            'payment_channel'    => $payment_channel,
            'payment_for'        => $payment_for,
            'unique_id'          => $unique_id,
            'return_route_name'  => $route_name,
            'meta_data'          => $meta_data
        ]);
    }
}
