<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceRequestSetting extends Model
{
    use HasFactory;

    protected $fillable = ['radius', 'max_ongoing_jobs'];

    /** 
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        static::creating(function ($serviceRequestSetting) {
            $serviceRequestSetting->uuid = (string) Str::uuid(); // Create uuid when a new payment gateway is to be created
        });
    }

}
