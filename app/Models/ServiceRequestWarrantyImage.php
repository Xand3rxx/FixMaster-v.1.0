<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class ServiceRequestWarrantyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_request_warranties_issued_id', 'user_id', 'name'
    ];




    /**
     * The "booted" method of the model.
     *
     * @return void
     */
  
 

    public function service_request_warranty_issued()
    {
        return $this->belongsTo(ServiceRequestWarrantyIssued::class);
    }

}