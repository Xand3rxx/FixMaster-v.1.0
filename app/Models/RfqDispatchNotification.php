<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqDispatchNotification extends Model
{
    use HasFactory;


    public $table = "rfq_dispatch_notifications";
    
    protected $fillable = [
        'rfq_id', 'supplier_id', 'dispatch', 'notification', 'service_request_id'
    ];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class);
    }


    public function service_request(){
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }
}

