<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Tax;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

use App\Models\Invoice;
use App\Models\Rfq;
use App\Models\RfqBatch;
use App\Models\ServiceRequest;
use App\Models\RfqSupplier;

use App\Traits\Invoices;

class SimulationController extends Controller
{
    use Invoices;

    public function diagnosticSimulation()
    {
        $serviceRequests = ServiceRequest::all();
        $data = [
            'serviceRequests' => $serviceRequests,
        ];
        return view('admin.simulation.diagnostic', $data);
    }

    public function endService($language, ServiceRequest $serviceRequest)
    {
        $service_request_id = $serviceRequest->id;
        $rfq_id = isset($serviceRequest->rfq->id) ? $serviceRequest->rfq->id : null;
        $warranty_id = 1;
        $sub_service_id = 1;
        $hours_spent = '2';

        $this->completedServiceInvoice($service_request_id, $rfq_id, $warranty_id, $sub_service_id, $hours_spent);
        return redirect()->route('admin.invoices', app()->getLocale());
    }

    public function completeService($language, ServiceRequest $serviceRequest)
    {
        $client_id = $serviceRequest->client_id;
        $service_request_id = $serviceRequest->id;
        $rfq_id = isset($serviceRequest->rfq->id) ? $serviceRequest->rfq->id : null;
        $warranty_id = 1;
        $sub_service_id = 1;
        $hours_spent = '2';

        $this->completedServiceInvoice($service_request_id, $rfq_id, $warranty_id, $sub_service_id, $hours_spent);
        return redirect()->route('admin.rfq', app()->getLocale());
    }

    public function rfqSimulation()
    {
        $serviceRequests = ServiceRequest::all();
        $data = [
            'serviceRequests' => $serviceRequests,
        ];
        return view('admin.simulation.rfq', $data);
    }

    public function rfqDetailsSimulation($language, ServiceRequest $serviceRequest)
    {
        $requestDetail = ServiceRequest::findOrFail($serviceRequest->id);

        $data = [
            'requestDetail'         =>  $requestDetail,
            'serviceRequests'       =>  $serviceRequest
        ];

        return view('admin.simulation.request_ongoing_details', $data);
    }

    public function simulateOngoingProcess($language, Request $request)
    {
        $clientId = $request->input('client_id');
        $serviceRequestId = $request->input('service_request_id');

        if(!empty($request->input('rfq_id'))){

            //Validate input fields for RFQ update
            $request->validate([
                'name'              =>  'required',
                'devlivery_fee'     =>  'required',
                'delivery_time'     =>  'required',
                'amount'            =>  'required',
            ]);

            // return $request->amount;
            $rfId =  $request->input('rfq_id');
            $totalAmount = 0;

            RfqSupplier::create([
                'rfq_id'            =>  $rfId,
                'supplier_id'       =>  1,
                'devlivery_fee'     =>  $request->input('devlivery_fee'),
                'delivery_time'     =>  \Carbon\Carbon::parse($request->input('delivery_time'), 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa'),
            ]);

            //Update amount for each entry on `rfq_batches` table for a RFQ Batch record
            foreach ($request->amount as $item => $value){
                RfqBatch::where('rfq_id', $rfId)->update([
                    'amount'    =>  $request->amount[$item],
                ]);

                $totalAmount += ($request->amount[$item] * $request->quantity[$item]);
            }

            //Update total_amount for RFQ in `rfqs` table
            Rfq::where('id', $rfId)->update([
                'total_amount'  =>  $totalAmount,
                'status'            =>  'Awaiting', //Status is set to `Awaiting Client's paymemt`
            ]);

//            (int $user_id, int $service_request_id, int $rfq_id, string $invoice_type, int $total_amount, int $amount_due, int $amount_paid, string  $status)

            $this->supplierInvoice($serviceRequestId, $rfId);
            return redirect()->route('admin.rfq', app()->getLocale());

        }

        if($request->input('intiate_rfq') == 'yes') {

            //Create RFQ Batch record on `rfqs` table
            $createRFQ = Rfq::create([
                'uuid' => Str::uuid('uuid'),
                'unique_id' => 'RFQ-' . strtoupper(substr(md5(time()), 0, 8)),
                'issued_by' => Auth::id(),
                'service_request_id' => $serviceRequestId,
                'client_id' => $clientId,
                'total_amount' => 0,
                'updated_at' => null,
            ]);

            $client_id = $clientId;
            $service_request_id = $serviceRequestId;
            $rfq_id = $createRFQ->id;
            $invoice_type = 'RFQ Invoice';
            $status = '1';


            $this->rfqInvoice($service_request_id, $rfq_id);


            //Create entries on `rfq_batches` table for a single RFQ Batch record
            foreach ($request->component_name as $item => $value) {
                RfqBatch::create([
                    'rfq_id' => $createRFQ->id,
                    'component_name' => $request->component_name[$item],
                    'model_number' => $request->model_number[$item],
                    'quantity' => $request->quantity[$item],
                ]);
            }

            return redirect()->route('admin.rfq', app()->getLocale());
        }
    }


}
