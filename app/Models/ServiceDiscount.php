<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceDiscount extends Model
{
    use HasFactory;

    protected $fillable = [
        'discount_id', 'service_id', 'discount_name', 'rate', 'notify', 'status', 'entity'
   ];
}
