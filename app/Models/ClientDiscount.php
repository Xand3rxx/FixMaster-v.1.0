<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Auth;

class ClientDiscount extends Model
{
    use HasFactory; 
    
    protected $fillable = [
         'discount_id', 'client_id', 'estate_id', 'service_id', 'availability'
    ];

    public function discount()
    {
        return $this->hasOne(Discount::class, 'id', 'discount_id');
    }

    public function discounts()
    {
        return $this->hasMany(Discount::class, 'id', 'discount_id');
    }

    /** 
     * Return all discounts assigned to a client
     * 
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */    
    public function scopeClientServiceRequestsDiscounts($query){
        return $query->select('id', 'discount_id')
        ->where('client_id', '=', Auth::id())
        ->where('availability', '=', 'unused')
        ->orderBy('id', 'ASC');
    }

    public function clientDiscount(){
        return $this->hasOne(Service::class, 'user_id', 'client_id');
     }
     public function clientDiscounts(){
             return $this->hasMany(Service::class, 'user_id', 'client_id');
     }

     public function serviceRequests()
     {
         return $this->hasMany(ServiceRequest::class, 'client_id', 'client_id');
     }
}

