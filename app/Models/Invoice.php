<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable = [
        'uuid', 'client_id', 'service_request_id', 'rfq_id', 'warranty_id', 'sub_service_id', 'unique_id', 'invoice_type', 'labour_cost', 'materials_cost', 'hours_spent', 'total_amount', 'amount_due', 'amount_paid', 'status', 'phase'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function client()
    {
        return $this->belongsTo(User::class);
    }

    public function clients()
    {
        return $this->belongsToMany(Client::class);
    }

    public function request()
    {
        return $this->belongsTo(ServiceRequest::class, 'service_request_id');
    }

    public function rfqs()
    {
        return $this->hasOne(Rfq::class, 'id', 'rfq_id');
    }

    public function serviceRequest()
    {
        return $this->hasOne(ServiceRequest::class, 'id', 'service_request_id');
    }

}
