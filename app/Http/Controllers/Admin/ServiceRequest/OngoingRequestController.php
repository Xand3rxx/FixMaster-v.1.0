<?php

namespace App\Http\Controllers\Admin\ServiceRequest;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;

class OngoingRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        return view('admin.requests.ongoing.index', [
            'requests'  =>  ServiceRequest::with('client', 'price',  'service_request_assignees')->where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Ongoing'])->latest('created_at')->get()
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
        // return \App\Models\Rfq::where('service_request_id', $serviceRequestID)
        //     // ->where('type', 'Request')
        //     ->with('rfqSupplier', 'rfqBatches', 'rfqSupplierInvoice.supplierDispatch')->first();
        return view('admin.requests.ongoing.show', [
            'serviceRequest'        =>  ServiceRequest::with(['price', 'service', 'client', 'serviceRequestMedias', 'adminAssignedCses', 'client', 'service_request_assignees', 'serviceRequestProgresses', 'serviceRequestReports', 'toolRequest', 'rfqs'])->where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Ongoing'])->firstOrFail(),

            'materials_accepted'    => \App\Models\Rfq::where('service_request_id', $serviceRequestID)
            // ->where('type', 'Request')
            ->with('rfqSupplier', 'rfqBatches', 'rfqSupplierInvoice.supplierDispatch')->first()
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
}
