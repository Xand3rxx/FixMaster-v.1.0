<?php

namespace App\Traits;

use App\Models\CollaboratorsPayment;
use Illuminate\Support\Str;

trait CsePayments
{
    public static function csePayment($userId, $service_request_id, $service_type)
    {
        return self::createCsePayment($userId, $service_request_id, $service_type);
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