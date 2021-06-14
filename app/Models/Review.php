<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Review extends Model
{
    use HasFactory;

    protected $fillable = ['client_id', 'service_request_id', 'service_id', 'reviews', 'status'];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }

    public function service(){
        return $this->hasOne(Service::class, 'id', 'service_id');
    }


    public function clientAccount(){
        return $this->hasOne(Account::class, 'user_id', 'client_id');
    }

}

