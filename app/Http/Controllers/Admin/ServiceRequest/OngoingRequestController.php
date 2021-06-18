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
        return ServiceRequest::with('client', 'price',  'service_request_assignees')->where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Ongoing'])->latest('created_at')->get();



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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        return ServiceRequest::with('client', 'price', 'service_request_assignees', 'serviceRequestMedias', 'serviceRequestProgresses', 'serviceRequestReports', 'toolRequest', 'rfqs')->where('uuid', $uuid)->firstorFail();
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
