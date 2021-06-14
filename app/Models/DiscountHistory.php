<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class DiscountHistory extends Model
{
    use HasFactory;

    protected $fillable = [
     
        'discount_id',
        'client_id',
        'estate_id',
        'service_id',
        'client_name', 
        'service_category', 
        'service_name', 
        'estate_name',
        'avaliability'
     

    ];

 

    protected $softDelete = false;


}

