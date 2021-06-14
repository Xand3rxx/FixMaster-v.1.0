<?php


namespace App\Traits;


use App\Models\Income;
use App\Models\Invoice;
use App\Models\Rfq;
use App\Models\Service;
use App\Models\ServiceRequest;
use App\Models\SubService;
use App\Models\Tax;
use App\Models\Warranty;
use Illuminate\Support\Str;
use phpDocumentor\Reflection\Types\Integer;
use App\Traits\GenerateUniqueIdentity as Generator;

trait Invoices
{
    use Generator;
    /**
     * Create a Diagnostic Invoice
     *
     * @param  int  $client_id
     * @param  int  $service_request_id
     * @param  string  $invoice_type
     * @param  int  $total_amount
     * @param  int  $amount_due
     * @param  int  $amount_paid
     * @param  string  $hours_spent
     * @param  string  $status
     * @param  float  $discount_fee
     *
     * @return \App\Models\Invoice|Null
     */

    public static function diagnosisInvoice($service_request_id, $rfq_id, $sub_service_id, $warranty_id, $hours_spent)
    {
        $serviceRequest = ServiceRequest::where('id', $service_request_id)->first();

        $client_id = $serviceRequest->client_id;
        $service_id = $serviceRequest->service_id;

        $serviceCharge = Service::where('id', $service_id)->first();
        $total_amount = $serviceCharge->service_charge;

        return self::getDiagnosisDetails($service_request_id, $rfq_id, $sub_service_id, $warranty_id, $hours_spent, $total_amount);
    }

    protected static function getDiagnosisDetails($service_request_id, $rfq_id, $sub_service_id, $warranty_id, $hours_spent, $total_amount)
    {
        $invoice_type = 'Diagnosis Invoice';
        $status = '1';
        $amount_paid = 0.00;
        $serviceRequest = ServiceRequest::where('id', $service_request_id)->first();
        $rfq = Rfq::where('id', $rfq_id)->first();
        $subService = SubService::where('id', $sub_service_id)->first();

        $client_id = $serviceRequest->client_id;

        $fixMasterMarkup = Income::select('amount', 'percentage')->where('income_name', 'FixMaster Markup')->first();
        $total_hours_spent = 0;

        $materials_cost = $rfq_id != null ? $rfq->total_amount : 0;

        if ($hours_spent == 1) {
            $total_hours_spent = $subService->first_hour_charge;
        } else {
            $total_hours_spent = $subService->first_hour_charge + $subService->subsequent_hour_charge * ($hours_spent - 1);
        }

        $markupPrice = $fixMasterMarkup->percentage * $total_hours_spent;
        $labour_cost = $total_hours_spent + $markupPrice;

        return self::createDiagnosisInvoice($client_id, $service_request_id, $rfq_id, $sub_service_id, $warranty_id, $invoice_type, $labour_cost, $hours_spent, $total_amount, $amount_paid, $status);
    }

    protected static function createDiagnosisInvoice($client_id, $service_request_id, $rfq_id, $sub_service_id, $warranty_id, $invoice_type, $labour_cost, $hours_spent, $total_amount, $amount_paid, $status)
    {
        $createInvoice = Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
            'service_request_id'    => $service_request_id,
            'rfq_id'                => $rfq_id,
            'warranty_id'           => $warranty_id,
            'sub_service_id'        => $sub_service_id,
            'unique_id'             => static::generate('invoices', 'INV-'),
            'invoice_type'          => $invoice_type,
            'labour_cost'           => $labour_cost,
            'hours_spent'           => $hours_spent,
            'total_amount'          => $total_amount,
            'amount_due'            => $total_amount,
            'amount_paid'           => $amount_paid,
            'status'                => $status,
        ]);

        $invoice_id = $createInvoice->id;
        self::getTotalAmount($invoice_id, $labour_cost, 0, $total_amount);
        return $createInvoice;
    }

    /**
     * Create a Rfq Invoice
     *
     * @param  int  $client_id
     * @param  int  $service_request_id
     * @param  int  $rfq_id
     * @param  string  $invoice_type
     * @param  string  $status
     */

    public static function rfqInvoice(int $service_request_id, int $rfq_id)
    {
        $serviceRequest = ServiceRequest::where('id', $service_request_id)->first();
        $client_id = $serviceRequest->client_id;

        return self::createRfqInvoice($client_id, $service_request_id, $rfq_id);
    }

    protected static function createRfqInvoice(int $client_id, int $service_request_id, int $rfq_id)
    {
        $invoice_type = 'Rfq Invoice';
        $status = '1';

        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
            'service_request_id'    => $service_request_id,
            'rfq_id'                => $rfq_id,
            'unique_id'             => static::generate('invoices', 'INV-'),
            'invoice_type'          => $invoice_type,
            'status'                => $status
        ]);
    }

    public static function supplierInvoice(int $service_request_id, int $rfq_id)
    {
        $serviceRequest = ServiceRequest::where('id', $service_request_id)->first();
        $rfq = Rfq::where('id', $rfq_id)->first();

        $invoice_type = 'Supplier Invoice';
        $client_id = $serviceRequest->client_id;
        $total_amount = $rfq->total_amount;
        $amount_paid = 0.00;
        $status = '1';

        return self::createSupplierInvoice($client_id, $service_request_id, $rfq_id, $invoice_type, $total_amount, $amount_paid, $status);
    }

    protected static function createSupplierInvoice(int $client_id, int $service_request_id, int $rfq_id, string $invoice_type, float $total_amount, float $amount_paid, string  $status)
    {
        return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $client_id,
            'service_request_id'    => $service_request_id,
            'rfq_id'                => $rfq_id,
            'unique_id'             => static::generate('invoices', 'INV-'),
            'invoice_type'          => $invoice_type,
            'total_amount'          => $total_amount,
            'amount_due'            => $total_amount,
            'amount_paid'           => $amount_paid,
            'status'                => $status,
            'phase'                 => '1'
        ]);
    }

    public static function completedServiceInvoice(\App\Models\ServiceRequest $service_request, string $hours_spent)
    {
        $rfq = Rfq::where('service_request_id', $service_request['id'])->first();
        $invoice_created = self::createcompletedServiceInvoice($service_request, $rfq, $hours_spent);
        if($invoice_created->rfq_id == null){
            // Send Notification of No RFQ
        }
        return $invoice_created;
    }

    protected static function createcompletedServiceInvoice($service_request, $rfq, $hours_spent)
    {
       return Invoice::create([
            'uuid'                  => Str::uuid('uuid'),
            'client_id'             => $service_request['client_id'],
            'service_request_id'    => $service_request->id,
            'rfq_id'                => $rfq->id ?? null,
            'warranty_id'           => 1,
            'unique_id'             => static::generate('invoices', 'INV-'),
            'invoice_type'          => 'Final Invoice',
            'hours_spent'           => $hours_spent,
            'status'                => '1',
            'phase'                 => '1'
        ]);
    }
}
