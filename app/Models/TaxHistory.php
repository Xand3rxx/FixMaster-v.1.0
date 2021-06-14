<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaxHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'tax_id', 'percentage', 
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id')->withDefault();
    }

    public function users()
    {
        return $this->hasMany(User::class, 'user_id')->withDefault();
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class, 'tax_id');
    }

    public function taxes()
    {
        return $this->hasMany(Tax::class, 'tax_id');
    }
}
