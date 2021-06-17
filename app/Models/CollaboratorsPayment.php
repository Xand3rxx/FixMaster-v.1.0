<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CollaboratorsPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'service_request_id', 'user_id', 'service_type', 'flat_rate', 'actual_labour_cost', 'actual_material_cost', 'amount_to_be_paid', 'amount_after_retention', 'retention_fee', 'labour_markup_cost', 'material_markup_cost', 'royalty_fee', 'logistics_cost', 'tax_fee'
    ];

    protected static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = Str::uuid()->toString();
        });
    }


     public function service_request()
     {
         return $this->belongsTo(ServiceRequest::class);
     }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id')->with('roles', 'account');
    }


}
