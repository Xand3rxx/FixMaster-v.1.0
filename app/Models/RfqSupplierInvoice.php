<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\GenerateUniqueIdentity as Generator;
use Illuminate\Support\Str;

class RfqSupplierInvoice extends Model
{
    use Generator;

    protected $fillable = [
        'rfq_id', 'supplier_id', 'delivery_fee', 'delivery_time', 'total_amount',
    ];

    /**
     * The "booted" method of the model.
     *
     * @return void
     */
    protected static function booted()
    {
        // Create a uuid when a new Serivce Request is to be created
        static::creating(function ($rfq) {
            $rfq->uuid = (string) Str::uuid();
        });
    }

    public function rfq()
    {
        return $this->belongsTo(Rfq::class)->with('serviceRequest');
    }

    public function supplier()
    {
        return $this->belongsTo(User::class, 'supplier_id')->with('account', 'supplier', 'contact');
    }

    public function supplierInvoiceBatch()
    {
        return $this->hasOne(RfqSupplierInvoiceBatch::class, 'rfq_batch_id', 'id');
    }

    public function supplierInvoiceBatches()
    {
        return $this->hasMany(RfqSupplierInvoiceBatch::class, 'rfq_supplier_invoice_id', 'id');
    }

    public function warranty_claim_supplier()
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'user_id');
    }

    public function rfqBatches()
    {
        return $this->hasMany(RfqBatch::class,'rfq_id', 'rfq_id');
    }

    public function warrantyIssued()
    {
        return $this->hasMany(ServiceRequestWarrantyReport::class,'supplier_id','causal_agent_id');
    }
    public function supplierDispatch()
    {
        return $this->hasOne(RfqSupplierDispatch::class, 'rfq_supplier_invoice')->latest('created_at');
    }

    public function selectedSupplier()
    {
        return $this->belongsTo(RfqSupplier::class, 'supplier_id', 'supplier_id');
    }

    // public function supplierDispatches()
    // {
    //     return $this->hasMany(RfqSupplierDispatch::class, 'rfq_supplier_invoic');
    // }

}
