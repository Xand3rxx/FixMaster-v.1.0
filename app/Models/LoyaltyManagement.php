<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;


class LoyaltyManagement extends Model
{
    use HasFactory;

    protected $table = "loyalty_managements";
    protected $fillable = [
     
        'client_id','wallet','points', 'type','amount'
    
    ];

 

    protected $softDelete = true;

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }
}
