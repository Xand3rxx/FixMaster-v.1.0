<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRequestWarrantyReport extends Model
{
    // use HasFactory;

    protected $fillable = [
        'user_id', 'service_request_warranties_issued_id', 'report','causal_agent_id', 'causal_reason'
    ];


    public function service_request_warranty_issued()
    {
        return $this->belongsTo(ServiceRequestWarrantyIssued::class);
    }

   
    public function rfqInvoices()
    {
        return $this->belongsTo(RfqSupplierInvoice::class,  'causal_agent_id','supplier_id',);
    }
}
