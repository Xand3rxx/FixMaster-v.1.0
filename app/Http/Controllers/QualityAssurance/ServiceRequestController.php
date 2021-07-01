<?php

namespace App\Http\Controllers\QualityAssurance;

use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\PaymentDisbursed;
use App\Http\Controllers\Controller;
use App\Models\CollaboratorsPayment;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequestWarranty;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $completedJobs = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 4);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Technician')
        ->get()->count();

        $ongoingJobs = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 2);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Technician')
        ->get()->count();

        $ongoingConsultations = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 2);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Consultant')
        ->get()->count();

        $pendingConsultations = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 1);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Consultant')->get();

        $completedConsultations = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 4);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Consultant')
        ->get()->count();
        $QApayments = CollaboratorsPayment::where('user_id',Auth::id())->get()->sum('amount_to_be_paid');      
        return view('quality-assurance.index', compact('completedJobs', 'ongoingJobs','ongoingConsultations','pendingConsultations','completedConsultations','QApayments'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function get_requests(Request $request)
    {
        $results = ServiceRequestAssigned::where('user_id', Auth::id())->with('users', 'service_request')
                 ->orderBy('created_at', 'DESC')->get();
        return view('quality-assurance.requests', compact('results'));
    }

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
        $result = ServiceRequest::where('uuid', $uuid)->first();
        $sRequest = ServiceRequestAssigned::where('user_id', Auth::id())
        ->where('service_request_id', $result->id)->first();

        // return view('quality-assurance.request_details', compact('result'));
        return view('quality-assurance.consultations.pending_details', compact('result', 'sRequest'));
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
        return view('quality-assurance.requests.active_details', compact('activeDetails','phone'));
    }

    public function QaJobAccept($language, $uuid){
        $request = ServiceRequest::where('uuid', $uuid)->first();
        ServiceRequestAssigned::where('user_id', Auth::id())->where('service_request_id', $request->id)->update([
            'qa_job_accepted' => 'Yes',
            'qa_job_acceptance_time' => now()
        ]);

        return redirect()->back()->with('success', 'Job Accepted');
    }

    public function getActiveJobs(Request $request){

        $activeJobs = ServiceRequestAssigned::whereHas('service_request', function ($query) {
            $query->where('status_id', 2);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Technician')
        ->get();
        return view('quality-assurance.requests.active', compact('activeJobs'));
    }

    public function getCompletedJobs(Request $request){

        $completedJobs = ServiceRequestAssigned::whereHas('service_request', function ($query) {
            $query->where('status_id', 4);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Technician')
        ->get();
        return view('quality-assurance.requests.completed', compact('completedJobs'));
    }

    public function getCancelledJobs(Request $request){

        $cancelledJobs = ServiceRequestAssigned::whereHas('service_request', function ($query) {
            $query->where('status_id', 3);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Technician')
        ->get();
        return view('quality-assurance.requests.cancelled', compact('cancelledJobs'));
    }

    public function getPendingConsultations(Request $request){
        $pendingConsults = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 1);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Consultant')->get();
        return view('quality-assurance.consultations.pending', compact('pendingConsults'));
    }

    public function getOngoingConsultationDetails($language, $uuid)
    {
        $result = ServiceRequest::where('uuid', $uuid)->first();
        $output = ServiceRequestAssigned::where('user_id', Auth::id())
        ->where('service_request_id', $result->id)->first();
        return view('quality-assurance.consultations.ongoing_details', compact('output'));
    }

    public function getOngoingConsultations(Request $request){
        $ongoingConsults = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 2);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Consultant')->get();
        return view('quality-assurance.consultations.ongoing', compact('ongoingConsults'));
    }

    public function getCompletedConsultations(Request $request){
        $completedConsults = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 4);
        })
        ->where('user_id', Auth::id())
        ->where('assistive_role', 'Consultant')->get();
        return view('quality-assurance.consultations.completed', compact('completedConsults'));
    }

    public function getWarranties(Request $request){
        $warranties = ServiceRequestWarranty::with('service_request_assignees', 'service_request')
                ->whereHas('service_request_assignees', function ($query){
                    $query->where('user_id', Auth::id());
                })->latest('created_at')->get();
        return view('quality-assurance.requests.warranty_claim', compact('warranties'));
    }

    public function warrantyDetails($language, $uuid)
    {
        $respond = ServiceRequest::where('uuid', $uuid)->first();
        $output = ServiceRequestWarranty::where('service_request_id', $respond->id)->first();
        return view('quality-assurance.requests.warranty', compact('output'));
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
