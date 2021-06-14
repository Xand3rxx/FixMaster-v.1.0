<?php

namespace App\Http\Controllers\Technician;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestAssigned;

class ServiceRequestController extends Controller
{



    public function getActiveRequests(Request $request){

        $activeRequest = ServiceRequestAssigned::whereHas('service_request', function ($query) {
            $query->where('status_id', 2);
        })
            ->where('user_id', Auth::id())
            ->where('assistive_role', 'Technician')
            ->get();
        return view('technician.requests.active')
            ->with('activeJobs', $activeRequest);
    }

    public function getCompletedRequests(Request $request){

        $completedJobs = ServiceRequestAssigned::whereHas('service_request', function ($query) {
            $query->where('status_id', 4);
        })
            ->where('user_id', Auth::id())
            ->where('assistive_role', 'Technician')
            ->get();
        return view('technician.requests.completed')
            ->with('completedJobs', $completedJobs);
    }

    public function getCancelledRequests(Request $request){

        $cancelledJobs = ServiceRequestAssigned::whereHas('service_request', function ($query) {
            $query->where('status_id', 3);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Technician')
        ->get();
        return view('technician.requests.cancelled')
        ->with('cancelledJobs', $cancelledJobs);
    }

    public function acceptedJobDetails($language, $uuid){
        $output = ServiceRequest::where('uuid', $uuid)->first();
         $activeDetails = ServiceRequestAssigned::where('user_id', Auth::id())
        ->where('service_request_id', $output->id)->first();

        foreach($activeDetails->service_request->users as $res){
            if($res->type->role->name === 'Customer Service Executive'){
                $phone = $res->contact->phone_number;
            }
        }
        return view('technician.requests.active_details', compact('activeDetails','phone'));
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
    public function show($id)
    {
        //
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
