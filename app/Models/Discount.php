<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Discount extends Model
{
    use HasFactory;

  

    protected $fillable = [
        'name', 'client_id', 'entity', 'rate', 'apply_discount','notify', 'duration_start', 'duration_end', 'description','parameter','created_by','status'
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
