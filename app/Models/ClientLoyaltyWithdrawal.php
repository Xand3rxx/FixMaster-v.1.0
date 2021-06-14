<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class ClientLoyaltyWithdrawal extends Model
{
    use HasFactory;

    protected $fillable = [
     
        'client_id','wallet','withdrawal', 'type','loyalty_mgt_id'
    
    ];


    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
