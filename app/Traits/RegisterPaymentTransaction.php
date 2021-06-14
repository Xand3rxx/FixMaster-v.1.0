<?php

namespace App\Traits;

use App\Models\Payment;
use Illuminate\Http\Request;

trait RegisterPaymentTransaction
{
    /**
     * Create an activity log
     * 
     * @param  int     $amount
     * @param  string  $payment_channel
     * @param  string  $payment_for
     * @param  string  $unique_id
     * @param  string  $status
     * @param  string  $reference_id
     * @param  string|NULL  $transaction_id
     * 
     * @return \App\Models\Payment
     */
    public static function payment(int $amount, string $payment_channel, string $payment_for, string $unique_id, string $status, string $reference_id, string $transaction_id = null)
    {
        return self::attepmtRegisteringPayment($amount, $payment_channel, $payment_for, $unique_id, $status, $reference_id, $transaction_id);
    }

    /**
     * Attempt to record the user log into the application.
     *
     * @param  int          $amount
     * @param  string       $payment_channel
     * @param  string       $payment_for
     * @param  string       $unique_id
     * @param  string       $status
     * @param  string       $reference_id
     * @param  string|NULL  $transaction_id
     * 
     * @return \App\Models\Payment
     */
    protected static function attepmtRegisteringPayment(int $amount, string $payment_channel, string $payment_for, string $unique_id, string $status, string $reference_id, string $transaction_id = null)
    {
        return Payment::firstOrCreate(
            ['reference_id' => $reference_id],
            [
                'amount' => $amount,
                'payment_channel' => $payment_channel,
                'payment_for' => $payment_for,
                'unique_id' => $unique_id,
                'transaction_id' => $transaction_id ?? NULL,
                'status' => $status
            ]
        );
    }
}
