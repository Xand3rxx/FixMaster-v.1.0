<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\WalletTransaction;

class Payment extends Model
{

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['user_id', 'reference_id', 'deleted_at', 'created_at', 'updated_at'];

    const PAYMENT_FOR = ['e-wallet', 'service-request', 'warranty', 'invoice'];
    const PAYMENT_CHANNEL = ['paystack' => 'paystack', 'flutterwave' => 'flutterwave', 'offline' => 'offline', 'wallet' => 'wallet', 'loyalty' => 'loyalty'];
    const STATUS = ['success' => 'success', 'pending' => 'pending', 'failed' => 'failed', 'timeout' => 'timeout'];


    public const PAYMENT_E_WALLET = 'e-wallet';
    public const PAYMENT_SERVICE_REQUEST = 'service-request';

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'meta_data' => 'array',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($payment) {
            $payment->user_id = auth()->user()->id; // Register the User making the payment transaction
            $payment->reference_id = \App\Traits\GenerateUniqueIdentity::generateReference(); // Create Payment reference, always unique
            $payment->status = self::STATUS['pending'];
        });
    }

    /**
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['user'];

    /**
     * Get the User associated with the payment.
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function service_request()
    {
        return $this->hasOne(ServiceRequest::class, 'unique_id', 'unique_id');
    }

    public function wallettransactions()
    {
        return $this->hasOne(WalletTransaction::class, 'payment_id');
    }
}
