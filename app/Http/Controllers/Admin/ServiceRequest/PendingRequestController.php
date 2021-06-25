<?php

namespace App\Http\Controllers\Admin\ServiceRequest;

use App\Traits\Utility;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use App\Models\ServiceRequestAssignCse;

class PendingRequestController extends Controller
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
        //Validate that a CSE uuid is been sent as part of the incoming request.
        $request->validate([
            'cse_user_uuid'         =>  'bail|required|uuid',
            'service_request_uuid'  =>  'bail|required|uuid'
        ]);

        //Check if uuid exists on `users` table.
        $cse = \App\Models\User::where('uuid', $request->cse_user_uuid)->with('account')->firstOrFail();

        //Check if uuid exists on `users` table.
        $serviceRequest = ServiceRequest::where('uuid',  $request->service_request_uuid)->firstOrFail();

        //Set `assignCse` to false before Db transaction
        (bool) $assignCse  = false;

        $actionUrl = Route::currentRouteAction();

        //Check if this CSE has already been assigned to this pending request.
        if((ServiceRequestAssignCse::where('user_id', $cse->id)->where('service_request_id', $serviceRequest->id)->exists()) == true){
            //Return back with error
            return back()->with('error', 'Sorry! You already assgined this CSE to this pending request.');
        }else{
            //Create new record for CSE on `service_request_assign_cses` table.
            DB::transaction(function () use ($cse, $serviceRequest, &$assignCse) {
                ServiceRequestAssignCse::create([
                    'user_id'               =>  $cse->id,
                    'service_request_id'    => $serviceRequest->id,
                ]);

                //Record service request progress of `A supplier sent an invoice`
                \App\Models\ServiceRequestProgress::storeProgress(1, $serviceRequest->id, 1, \App\Models\SubStatus::where('uuid', '3f8d1494-a53b-4671-8447-10d3ca92b270')->firstOrFail()->id);

                $assignCse = true;
            });
        }

        if($assignCse){
            //Send mail to CSE
            $template = 'ADMIN_ASSIGNED_CSE_TO_A_JOB';
            if (!empty((string)$template)) {
                $sendMail = new \App\Http\Controllers\Messaging\MessageController();

                $messageBody = collect([
                    'firstname' => $cse['account']['first_name'],
                    'lastname'  => $cse['account']['last_name'],
                    'url'       => url()->to("/")."/en/cse/requests/".$request->service_request_uuid, 
                ]);

                $sendMail->sendNewMessage('', 'info@fixmaster.com.ng', $cse['email'], $messageBody, $template);
            }

            $this->log('Request', 'Informational', $actionUrl, $request->user()->email.' assigned '.$cse['account']['first_name'].' '.$cse['account']['last_name'].' to '. $serviceRequest->unique_id.' request.');

            return back()->with('success', $cse['account']['first_name'].' '.$cse['account']['last_name'].' has been assigned to '. $serviceRequest->unique_id.' request.');

        }else{

            $this->log('Errors', 'Error', $actionUrl, 'An error occurred while trying to assign '.$cse['account']['first_name'].' '.$cse['account']['last_name'].' to '.$serviceRequest->unique_id.' request.');

            return back()->with('error', 'An error occurred while trying to assign '.$cse['account']['first_name'].' '.$cse['account']['last_name'].' to '. $serviceRequest->unique_id.' request.');
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($language, $uuid)
    {
        return view('admin.requests.pending.show', [
            'serviceRequest'    =>  ServiceRequest::where('uuid', $uuid)->with(['price', 'service', 'client', 'serviceRequestMedias', 'adminAssignedCses'])->firstOrFail(),
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
}
