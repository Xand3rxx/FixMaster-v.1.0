<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RfqSupplierDispatch extends Model
{
    const CSE_STATUS = ['Pending', 'Awaiting', 'Shipped', 'Delivered'];
    const CSE_MATERIAL_ACCEPTANCE = ['Yes', 'No'];

    protected $fillable = ['rfq_id', 'rfq_supplier_invoice', 'supplier_id', 'unique_id', 'courier_name', 'courier_phone_number', 'delivery_medium', 'cse_status', 'cse_material_acceptance', 'supplier_status', 'cse_comment', 'comment'];

    public function rfq()
    {
        return $this->belongsTo(Rfq::class);
    }

    public function supplierInvoice()
    {
        return $this->belongsTo(RfqSupplierInvoice::class, 'rfq_supplier_invoice')->with('supplierInvoiceBatches');
    }
}
