<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceRequestWarrantyIssued extends Model
{
    use HasFactory;
    protected $table = "service_request_warranties_issued";
    protected $fillable = [
        'service_request_warranty_id',
         'cse_id', 
         'technician_id', 
         'completed_by',
         'admin_comment', 
        'cse_comment',
        'date_resolved',
        'scheduled_datetime'
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

    public function service_request_warranty(){
        return $this->belongsTo(ServiceRequestWarranty::class, 'id', 'service_request_warranty_id');
    }

    public function service_request_warranty_image(){
        return $this->hasMany(ServiceRequestWarrantyImage::class, 'service_request_warranties_issued_id');
    }
    
    public function service_request_warranty_images(){
        return $this->hasMany(ServiceRequestWarrantyImage::class, 'service_request_warranties_issued_id', 'id');
    }

    public function warrantyImage(){
        return $this->hasMany(ServiceRequestWarrantyImage::class, 'service_request_warranties_issued_id');
    }

    public function warrantReport()
    {
        return $this->hasMany(ServiceRequestWarrantyReport::class, 'service_request_warranties_issued_id');
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'cse_id', 'user_id');
    }

    public function completedBy()
    {
        return $this->belongsTo(Account::class, 'completed_by', 'user_id');
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