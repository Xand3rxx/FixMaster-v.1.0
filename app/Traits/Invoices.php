<?php


namespace App\Traits;


use App\Models\Income;
use Illuminate\Support\Facades\URL;
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

    public static function completedServiceInvoice(\App\Models\ServiceRequest $service_request, string $hours_spent)
    {
        $rfq = Rfq::where('service_request_id', $service_request['id'])->first();
        $invoice_created = self::createcompletedServiceInvoice($service_request, $rfq, $hours_spent);
        if($invoice_created->rfq_id == null){
            // Send Notification of No RFQ
            $messenger = new \App\Http\Controllers\Messaging\MessageController();
            $template_feature = 'CUSTOMER_FINAL_INVOICE';
            $mail_data = collect([
                'firstname' => $invoice_created['client']->account->first_name,
                'lastname' => $invoice_created['client']->account->last_name,
                'job_ref' => $invoice_created['serviceRequest']->unique_id,
                'url' => route('invoice', ['locale' => app()->getLocale(), 'invoice' => $invoice_created['uuid']])
            ]);
//            dd($invoice_created['client']['email']);
            $messenger->sendNewMessage(null, 'info@fixmaster.com.ng', $invoice_created['client']['email'], $mail_data, $template_feature);
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
