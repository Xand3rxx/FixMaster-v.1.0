<?php

namespace App\Http\Controllers\Admin\ServiceRequest;

use App\Traits\Utility;
use App\Traits\Loggable;
use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Traits\CancelRequest;
use App\Models\ServiceRequest;
use App\Models\WalletTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\ServiceRequestProgress;

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
        $serviceRequest = ServiceRequest::where('uuid', $uuid)->with('client', 'price', 'payment', 'status')->firstOrFail();

        return (($this->initiateCancellation($request, $serviceRequest) == true) ? back()->with('success', $serviceRequest->unique_id.' request has been cancelled.') : back()->with('error', 'An error occurred while trying to to assign cancel '. $serviceRequest->unique_id.' request.'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function markCompletedRequest($language, $uuid, Request $request, ){

        $requestExists =  ServiceRequest::where('uuid', $uuid)->firstOrFail();

        $updateMarkasCompleted = $this->markCompletedRequestTrait($request->user()->id, $uuid);

        $actionUrl = Route::currentRouteAction();

        if($updateMarkasCompleted ){

            //Record success activity log
            $this->log('request', 'Informational', $actionUrl, auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ' marked '.$requestExists->unique_id.' service request as completed.');

            //Record service request progress of `Admin marked job as completed`
            ServiceRequestProgress::storeProgress(auth()->user()->id, $requestExists->id, 4, SubStatus::where('uuid', 'ce316687-62d8-45a9-a1b9-f75da104fc18')->firstOrFail()->id);

            //Return back to view
            return back()->with('success', $requestExists->unique_id.' was marked as completed successfully.');

        }else{
            
            //Record error activity log
            $this->log('Errors', 'Error', $actionUrl, 'An error occurred while '.auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') tried to mark '.$requestExists->unique_id.' service request as completed.');

            //Return back to view
            return back()->with('error', 'An error occurred while trying to mark '.$requestExists->unique_id.' service request as completed.');
        }
    }

    
}
