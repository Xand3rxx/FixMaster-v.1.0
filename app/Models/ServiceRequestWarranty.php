<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceRequestWarranty extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id', 'warranty_id', 'service_request_id', 'start_date', 'expiration_date', 'amount', 'status', 'initiated', 'has_been_attended_to', 'reason',
    ];



    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new serivce uuid is to be created
        static::creating(function ($service) {
            $service->uuid = (string) Str::uuid();
        });
    }

    public function service_request(){
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'client_id', 'id')->with(['account']);
    }

    public function name()
    {
        return $this->hasOne(Account::class, 'user_id', 'client_id');
    }

    public function warranty()
    {
        return $this->hasOne(Warranty::class, 'id', 'warranty_id');
    }

    public function payment()
    {
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }

    public function service_request_warranty_issued(){
        return $this->hasOne(ServiceRequestWarrantyIssued::class, 'service_request_warranty_id', 'id');
    }

    public function service_request_assignees(){

        return $this->hasMany(ServiceRequestAssigned::class, 'service_request_id')->with('user');
    }

    public function service_request_report(){
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id')->with('service', 'client');
    }


    /**
     * Scope a query to only include all pending requests
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    //Scope to return all services
    public function scopeUnresolvedWarranties($query)
    {
        return $query->select('*')
        ->where('has_been_attended_to', 'No');
    }

}
