<?php

namespace App\Traits;

use App\Models\CollaboratorsPayment;
use Illuminate\Support\Str;

// Generate re-occurring payment for CSE

trait CsePayments
{
    public static function csePayment($user_id, $service_request_id, $service_type)
    {
        return self::createCsePayment($user_id, $service_request_id, $service_type);
    }

    protected static function createCsePayment($user_id, $service_request_id, $service_type)
    {
        return CollaboratorsPayment::create([
            'uuid' =>  Str::uuid('uuid'),
            'service_request_id' => $service_request_id,
            'user_id' => $user_id,
            'service_type' => $service_type,
            'flat_rate' => 1000,
        ]);
    }

}