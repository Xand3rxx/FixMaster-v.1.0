<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Referral extends Model
{
    use HasFactory;
    

    protected $fillable = [
         'user_id',
        'referral_code',
        'referral_count',
        'referral_amount',
        'referral_discount',
        'referral',
        'created_by',
        'status'
    ];


    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

}
