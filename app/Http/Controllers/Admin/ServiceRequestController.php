<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\Route;
use App\Traits\Utility;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestProgress;

class ServiceRequestController extends Controller
{
    use Utility, Loggable;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('admin.requests.pending.index', [
            'requests'  =>  ServiceRequest::with('client', 'price')->where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Pending'])->latest('created_at')->get()
        ]);
    }


    /**
     * Display the selected pending service request detail.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function ongoingRequestDetails($language, $uuid)
    {

        return \App\Models\Role::where('slug', 'cse-user')->with('users')
        ->whereHas('users', function($query){
            $query->where('job_availability', 'Yes');
        })
        ->firstOrFail();


        return view('admin.requests.pending.show', [
            'cses'    =>  \App\Models\Role::where('slug', 'cse-user')->with('users')->firstOrFail(),
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
     * Display the selected pending service request detail.
     *
     * @param  int  $uuid
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {

        // return \App\Models\Cse::where('job_availability', 'Yes')->with('user', 'user.ratings')->get();

        // $service_request = ServiceRequest::where('uuid', $uuid)->with(['price', 'service', 'service.subServices', 'client', 'service_request_cancellation', 'invoice', 'serviceRequestMedias', 'serviceRequestProgresses', 'serviceRequestReports', 'toolRequest'])->firstOrFail();

        return view('admin.requests.pending.show', [
            'serviceRequest'    =>  ServiceRequest::where('uuid', $uuid)->with(['price', 'service', 'service.subServices', 'client', 'serviceRequestMedias'])->firstOrFail(),
            'cses'    =>  \App\Models\Cse::where('job_availability', 'Yes')->with('user', 'user.ratings')->get(),
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


    public function markCompletedRequest(Request $request, $language, $id){

        $requestExists =  ServiceRequest::where('uuid', $id)->firstOrFail();

         $updateMarkasCompleted = $this->markCompletedRequestTrait(Auth::id(), $id);

        if($updateMarkasCompleted ){

            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') marked '.$requestExists->unique_id.' service request as completed.');

            //Record service request progress of `Admin marked job as completed`
            ServiceRequestProgress::storeProgress(auth()->user()->id, $requestExists->id, 4, \App\Models\SubStatus::where('uuid', 'ce316687-62d8-45a9-a1b9-f75da104fc18')->firstOrFail()->id);

            return redirect()->route('admin.requests.index', app()->getLocale())->with('success', $requestExists->unique_id.' was marked as completed successfully.');

        }else{

         //activity log
            return back()->with('error', 'An error occurred while trying to mark '.$requestExists->unique_id.' service request as completed.');
        }
    }


}
