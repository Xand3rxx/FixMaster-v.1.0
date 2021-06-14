<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Rfq;
use App\Models\ServiceRequestWarranty;
use App\Models\SubStatus;
use App\Models\Warranty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\In;

use App\Traits\Loggable;
use App\Traits\Invoices;

class ClientDecisionController extends Controller
{
    use Loggable, Invoices;

//    public function __construct() {
//        $this->middleware('auth:web');
//    }
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function __invoke(Request $request)
    {
        $clientAcceptedDiagId = SubStatus::select('id')->where('phase', 10)->first();
        $clientDeclinedDiagId = SubStatus::select('id')->where('phase', 11)->first();
        $clientAcceptedSuppId = SubStatus::select('id')->where('phase', 18)->first();
        $clientDeclinedSuppId = SubStatus::select('id')->where('phase', 19)->first();
        $invoice = Invoice::find($request->invoice_id);
        $rfq = Rfq::where('service_request_id', $invoice->serviceRequest->id)->first();
        $diagnosisInvoice = Invoice::where('service_request_id', $invoice->serviceRequest->id)->where('invoice_type', 'Diagnosis Invoice')->first();
//        dd($invoice['uuid']);
        $warranty = $request['warranty_id'] ? Warranty::findOrFail($request->warranty_id) : '' ;
        if ($request['client_choice'] == 'accepted')
        {
//            dd($request);
            if($request['invoice_type'] == 'Supplier Invoice')
            {
                \Illuminate\Support\Facades\DB::transaction(function () use ($invoice, $request, $rfq, $clientAcceptedSuppId, $diagnosisInvoice, &$completionInvoice) {
                    //Update the RFQ Table
                    $rfq->update([
                        'status' => 'Delivered',
                        'accepted' => 'Yes'
                    ]);

                    // Update the Supplier Invoice row to hide the Invoice from the client
                    $invoice->update([
                        'phase' => '0'
                    ]);
                    $completionInvoice = $this->completedServiceInvoice($request->request_id,$invoice->rfq_id, $request->warranty_id, $diagnosisInvoice->sub_service_id, $diagnosisInvoice->hours_spent);
                    $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ' accepted supplier return invoice.');
                    \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientAcceptedSuppId->id);

                });
                return redirect()->route('invoice', [app()->getLocale(), $completionInvoice->uuid])->with('success', 'Supplier Return Invoice Accepted');
            }
            else
            {

                \Illuminate\Support\Facades\DB::transaction(function () use ($invoice, $request, $warranty, $clientAcceptedDiagId, $rfq, &$completionInvoice) {
                    $InitiateWarranty = ServiceRequestWarranty::create([
                        'client_id'           => $request->client_id,
                        'warranty_id'         => $request->warranty_id,
                        'service_request_id'  => $request->request_id,
                        'amount'              => $warranty->percentage * $request->amount
                    ]);
                    if($InitiateWarranty) {
                        \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientAcceptedDiagId->id);
                        if(!$rfq)
                        {
                           $completionInvoice = $this->completedServiceInvoice($request->request_id,null, $request->warranty_id, $invoice->sub_service_id, $invoice->hours_spent);
                            $invoice->update([
                                'phase' => '0'
                            ]);
                        }
                        else{
                        $invoice->update([
                            'phase' => '0'
                        ]);
                        }
                    }
                    $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ' accepted estimated final invoice.');
                });
                if(!$rfq)
                {
                    return redirect()->route('invoice', [app()->getLocale(), $completionInvoice->uuid])->with('success', 'Estimated Final Invoice Accepted');
                }else{
                    return redirect()->route('client.service.all', app()->getLocale())->with('success', 'Estimated Final Invoice Accepted');
                }
            }
        }

        else if($request['client_choice'] == 'declined')
        {
            if($request['invoice_type'] == 'Supplier Invoice')
            {
                $diagnosisInvoice = Invoice::where('service_request_id', $invoice['service_request_id'])->where('invoice_type', 'Diagnosis Invoice')->first();
                $rfq = Rfq::where('service_request_id', $invoice->serviceRequest->id)->first();
                \Illuminate\Support\Facades\DB::transaction(function () use ($invoice, $request, $clientDeclinedSuppId, $diagnosisInvoice, $rfq) {
                    //Update the RFQ Table
                    $rfq->update([
                        'status' => 'Rejected',
                        'accepted' => 'No'
                    ]);
                    // Update the Diagnosis Invoice row to display the Invoice to the client
                    $diagnosisInvoice->update([
                        'phase' => '2'
                    ]);

                    // Update the Supplier Invoice row to hide the Invoice from the client
                    $invoice->update([
                        'phase' => '0'
                    ]);
                    $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ' declined supplier return invoice.');
                    \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientDeclinedSuppId->id);
                });
                return redirect()->route('invoice', [app()->getLocale(), $diagnosisInvoice->uuid])->with('success', 'Diagnosis Invoice Accepted');
            }
            else{
                \App\Models\ServiceRequestProgress::storeProgress(auth()->user()->id, $request->request_id, 2, $clientDeclinedDiagId->id);
                $invoice->update([
                    'phase' => '2'
                ]);
                $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ' accepted diagnosis invoice.');
                return redirect()->route('invoice', [app()->getLocale(), $invoice->uuid])->with('success', 'Diagnosis Invoice Accepted');
            }
        }
    }

    public function clientDecline($language, Request $request)
    {
        $invoiceUUID = $request->invoiceUUID;

        $invoiceExists = Invoice::where('uuid', $invoiceUUID)->firstOrFail();

        $invoiceExists->update([
           'invoice_type' => 'Diagnosis Invoice',
           'phase' => '2'
        ]);

        return response()->json($invoiceExists);
    }

    public function clientAccept($language, Request $request)
    {
        $invoiceUUID = $request->invoiceUUID;

        $invoiceExists = Invoice::where('uuid', $invoiceUUID)->firstOrFail();

        $invoiceExists->update([
            'phase' => '2'
        ]);

        return response()->json($invoiceExists);
    }

    public function clientReturn($language, Request $request)
    {
        $invoiceUUID = $request->invoiceUUID;

        $invoiceExists = Invoice::where('uuid', $invoiceUUID)->firstOrFail();

        $invoiceExists->update([
            'invoice_type' => 'Final Invoice',
            'phase' => '1'
        ]);

        return response()->json($invoiceExists);
    }
}
