<?php

namespace App\Http\Controllers\Admin\ServiceRequest;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestProgress;

class ActionsController extends Controller
{
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
    public function markCompletedRequest($language, $id, Request $request, ){

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
