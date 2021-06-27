<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RfqBatch extends Model
{
    use HasFactory;

    public $table = "rfq_batches";

    public $timestamps = false;

    protected $fillable = [
        'rfq_id', 'manufacturer_name', 'model_number', 'component_name', 'quantity', 'size', 'unit_of_measurement', 'image', 'amount'
    ];


    public function rfq()
    {
        return $this->belongsTo(Rfq::class, 'id', 'rfq_id');
    }

    public function rfqs()
    {
        return $this->hasMany(Rfq::class, 'id', 'rfq_id');
    }

    public function supplierInvoiceBatch()
    {
        return $this->hasOne(RfqSupplierInvoiceBatch::class, 'rfq_batch_id', 'id');
    }
    
    public function supplierInvoiceBatches()
    {
        return $this->hasMany(RfqSupplierInvoiceBatch::class, 'rfq_batch_id', 'id');
    }
}
