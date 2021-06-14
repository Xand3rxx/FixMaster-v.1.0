<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PriceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'price_id', 'amount', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id')->withDefault();
    }

    public function price()
    {
        return $this->belongsTo(Price::class, 'price_id');
    }

    public function prices()
    {
        return $this->hasMany(Price::class, 'price_id');
    }
}
