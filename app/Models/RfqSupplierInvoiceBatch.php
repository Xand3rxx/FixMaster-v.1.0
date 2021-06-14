<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqSupplierInvoiceBatch extends Model
{
    use HasFactory;

    public $table = 'rfq_supplier_invoice_batches';

    public $timestamps = false;

    protected $fillable = [
        'rfq_supplier_invoice_id', 'rfq_batch_id', 'quantity', 'unit_price', 'total_amount',
    ];


  

    public function rfqBatch()
    {
        return $this->belongsTo(RfqBatch::class, 'rfq_batch_id');
    }
}
