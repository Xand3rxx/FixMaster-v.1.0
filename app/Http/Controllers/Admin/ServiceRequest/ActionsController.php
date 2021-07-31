<?php

namespace App\Http\Controllers\Admin\ServiceRequest;

use App\Traits\Utility;
use App\Traits\Loggable;
use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Traits\CancelRequest;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
class ActionsController extends Controller
{
    use Utility, Loggable, CancelRequest;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.requests.completed.index', [
            'requests'  =>  ServiceRequest::with('client', 'price')->where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Completed'])->latest('created_at')->get()
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function cancelledRequests()
    {
        return view('admin.requests.cancelled.index', [
            'requests'  =>  ServiceRequest::with('client', 'price')->where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Canceled'])->latest('created_at')->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        $serviceRequestID = ServiceRequest::where('uuid', $uuid)->firstOrFail()->id;

        return view('admin.requests.completed.show', [
            'serviceRequest'        =>  ServiceRequest::with(['price', 'service', 'client', 'serviceRequestMedias', 'adminAssignedCses', 'client', 'service_request_assignees', 'serviceRequestProgresses', 'serviceRequestReports', 'toolRequest', 'rfqs'])->where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Completed'])->firstOrFail(),

            'materials_accepted'    => \App\Models\Rfq::where('service_request_id', $serviceRequestID)
            // ->where('type', 'Request')
            ->with('rfqSupplier', 'rfqBatches', 'rfqSupplierInvoice.supplierDispatch')->first()
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function cancelledRequestDetails($language, $uuid)
    {
        $serviceRequestID = ServiceRequest::where('uuid', $uuid)->firstOrFail()->id;

        return view('admin.requests.cancelled.show', [
            'serviceRequest'        =>  ServiceRequest::with(['price', 'service', 'client', 'serviceRequestMedias', 'adminAssignedCses', 'client', 'service_request_assignees', 'serviceRequestProgresses', 'serviceRequestReports', 'toolRequest', 'rfqs'])->where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Canceled'])->firstOrFail(),

            'materials_accepted'    => \App\Models\Rfq::where('service_request_id', $serviceRequestID)
            // ->where('type', 'Request')
            ->with('rfqSupplier.rfqSupplierInvoice', 'rfqBatches', 'rfqSupplierInvoice.supplierDispatch')->first()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function cancelRequest($language, $uuid, Request $request){

        //Validate the incoming request.
        $request->validate([
            'reason'    =>  'bail|required|string',
        ]);

        //Check if uuid exists on `users` table.
        $serviceRequest = ServiceRequest::where('uuid', $uuid)->with('client', 'price', 'payment')->firstOrFail();

        return (($this->initiateCancellation($request, $serviceRequest) == true) ? back()->with('success', $serviceRequest->unique_id.' request has been cancelled.') : back()->with('error', 'An error occurred while trying to cancel '. $serviceRequest->unique_id.' request.'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markCompletedRequest($language, $uuid){

        //Check if uuid exists on `service_requests` table.
        $serviceRequest = ServiceRequest::where('uuid', $uuid)->with('client', 'price', 'payment')->firstOrFail();

        if(!\App\Models\ServiceRequestPayment::where(['user_id'  => $serviceRequest['client_id'], 'service_request_id' => $serviceRequest['id'], 'payment_type' =>  'final-invoice-fee'])->exists()){
            return back()->with('error', 'Sorry! This customer is yet to make payment for final invoice.');
        }

        return (($this->markCompletedRequestTrait($serviceRequest) == true) ? back()->with('success', $serviceRequest->unique_id.' request has been marked as completed.') : back()->with('error', 'An error occurred while trying to mark '. $serviceRequest->unique_id.' request as completed.'));

    }

    
}
