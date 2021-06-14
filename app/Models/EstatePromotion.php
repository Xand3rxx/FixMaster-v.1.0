<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EstatePromotion extends Model
{
    use HasFactory;

    protected $fillable = [
        'estate_id', 'discount_percentage', 'discount_duration', 'is_active'
    ];

    public function estate()
    {
        return $this->belongsTo(Estate::class);
    }
}
