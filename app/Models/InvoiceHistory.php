<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid', 'user_id', 'service_request_id', 'rfq_id', 'invoice_number', 'invoice_type', 'total_amount', 'amount_due', 'amount_paid', 'status'
    ];
}
