<?php

namespace App\Http\Controllers\CSE;

use Auth;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Account;
use App\Models\Contact;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestAssigned;
use App\Models\User;
use App\Models\Cse;
use Illuminate\Support\Facades\Route;

use App\Traits\Loggable;


class CustomerServiceExecutiveController extends Controller
{
    use Loggable;

    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $cse = ServiceRequestAssigned::where('user_id', $request->user()->id)->with('service_request')->get();
        // Data Needed on dashboard page
        // 1. CSE Ratings
        // 2. CSE Earnings
        return view('cse.index', [
            // 'earnings'
            // 'ratings'
            'completed' => $cse->filter(function ($each) {
                return $each['service_request']['status_id'] == ServiceRequest::SERVICE_REQUEST_STATUSES['Completed'];
            })->count(),
            'canceled' => $cse->filter(function ($each) {
                return $each['service_request']['status_id'] == ServiceRequest::SERVICE_REQUEST_STATUSES['Canceled'];
            })->count(),
            'ongoing' => $cse->filter(function ($each) {
                return $each['service_request']['status_id'] == ServiceRequest::SERVICE_REQUEST_STATUSES['Ongoing'];
            })->count(),
            'available_requests' => Cse::isAvailable() ? ServiceRequest::where('status_id', ServiceRequest::SERVICE_REQUEST_STATUSES['Pending'])->with('service', 'address')->get() : []
        ]);
    }



    /**
     * Accept Service Request Job
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function setJobAcceptance(Request $request)
    {
        $request->validate(['service_request_uuid' => 'required|uuid']);
        $acceptedJob = new \App\Http\Controllers\ServiceRequest\JobAcceptanceController(ServiceRequest::where('uuid', $request->service_request_uuid)->firstOrFail(), $request->user());
        return $acceptedJob->cseJobAcceptance();
    }

    /**
     * Accept Service Request Job
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function setAvailablity(Request $request)
    {
        return ($request->user()
            ? (($request->user()->cse->job_availability == CSE::JOB_AVALABILITY[0]
                ? $request->user()->cse->update(['job_availability' => CSE::JOB_AVALABILITY[1]])
                : $request->user()->cse->update(['job_availability' => CSE::JOB_AVALABILITY[0]]))
                ? back()->with('success', 'Availability updated successfully!')
                : back()->with('error', 'Error occured updating availability'))
            : redirect()->route('login'));
    }

    public function getAvailableToolQuantity(Request $request)
    {
        if ($request->ajax()) {
            $toolId = $request->get('tool_id');

            $toolExists = \App\Models\ToolInventory::where('id', $toolId)->firstOrFail();

            $availableQuantity =  $toolExists->available;

            return $availableQuantity;
        }
    }

    public function getSubServices(Request $request)
    {
        if ($request->ajax()) {
            return response()->json(['sub_services' => \App\Models\SubService::where('service_id', $request->get('service_id'))->get()]);
        }
        return response()->json(['sub_services' => null], 404);
    }

    /**
     * Accept CSE Ratings from view and transfer to Ratings Controller for handling
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Controllers\RatingController $ratings
     * 
     * @return \Illuminate\Http\Response
     */
    public function user_rating(Request $request, \App\Http\Controllers\RatingController $ratings)
    {
        return $ratings->handleRatings($request);
    }

    /**
     * Accept CSE Ratings Update from view and transfer to Ratings Controller for handling
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Http\Controllers\RatingController $ratings
     * 
     * @return \Illuminate\Http\Response
     */
    public function update_cse_service_rating(Request $request, \App\Http\Controllers\RatingController $updateRatings)
    {
        return $updateRatings->handleServiceRatings($request);
    }

    private function validateUpdateRequest()
    {
        return request()->validate([
            'first_name'         => 'required|string',
            'middle_name'        => 'string',
            'last_name'          => 'required|string',
            'gender'             => 'required',
            'phone_number'       => 'required|numeric|min:11',
            'profile_avatar'     => 'file',
            'bank_id'            => 'required',
            'account_number'     => 'numeric',
            'full_address'       => 'required',
        ]);
    }


    public function warranty_claims_list()
    {
        // $warranties = \App\Models\ServiceRequestAssigned::with('service_request_warranty', 'user.account', 'service_request')
        //     ->where(['status' => 'Active'])
        //     ->get();
            $warranties = \App\Models\ServiceRequestWarranty::with('user.account', 'service_request', 'warranty', 'service_request_warranty_issued')->orderBy('has_been_attended_to', 'ASC')->latest()->get();
   

        return view('cse.warranties.index', [
            'issuedWarranties' =>  $warranties
        ]);
    }

    public function warranty_claims()
    {
        return view('cse.warranties.index');
    }

    public function warranty_details($language, $uuid)
    {


        // find the service reqquest using the uuid and relations
        $service_request = \App\Models\ServiceRequest::where('uuid', $uuid)->with(['price', 'service', 'service.subServices'])->firstOrFail();

        $request_progress = \App\Models\ServiceRequestProgress::where('service_request_id', $service_request->id)->with('user', 'substatus')->latest('created_at')->get();
       
        // find the technician role CACHE THIS DURING PRODUCTION

        $technicainsRole = \App\Models\Role::where('slug', 'technician-artisans')->first();
        $rfq        = \App\Models\Rfq::where('service_request_id', $service_request->id)->first();
        $rfqWarranty        = \App\Models\Rfq::where(['issued_by'=> Auth::user()->id, 'service_request_id' => $service_request->id, 'type'=> 'Warranty'])->where('status', '<>', 'Rejected')->latest()->first();
        $rfqSupplierDispatch =   $rfqWarranty ? \App\Models\RfqSupplierDispatch::where(['rfq_id'=> $rfqWarranty->id, 'cse_status'=> 'Pending' ])->get(): null;



        $scheduleDate =!empty($service_request->service_request_warranty->service_request_warranty_issued) ? 
        $service_request->service_request_warranty->service_request_warranty_issued->scheduled_datetime: '';
        $issued_id = !empty($service_request->service_request_warranty->service_request_warranty_issued) ? 
        $service_request->service_request_warranty->service_request_warranty_issued->id: '';
        $technicianExist = !empty($service_request->service_request_warranty->service_request_warranty_issued) ? 
        $service_request->service_request_warranty->service_request_warranty_issued->technician_id : [];
        $getCausalTechnician =  $issued_id? \App\Models\ServiceRequestWarrantyReport::where(['service_request_warranties_issued_id' => $issued_id ])->get(): [];
        $causalTechnician  = [];
        $causalSuppliers  = [];
        if(!empty($getCausalTechnician)){
        foreach($getCausalTechnician as $val) {
          if($val->causal_agent_id != 0)
            if( \CustomHelpers::getUserDetail($val->causal_agent_id)->roles[0]->url == 'technician')
            $causalTechnician [] = $val->causal_agent_id;
            elseif( \CustomHelpers::getUserDetail($val->causal_agent_id)->roles[0]->url == 'supplier')
            $causalSuppliers [] = $val->causal_agent_id;
          
        }
        }


        (array) $variables = [
            'service_request' => $service_request,
            'technicians' => \App\Models\UserService::where('service_id', $service_request->service_id)->where('role_id', $technicainsRole->id)->with('user')->get(),
            'qaulity_assurances'    =>  \App\Models\Role::where('slug', 'quality-assurance-user')->with('users')->firstOrFail(),
            'request_progress' => $request_progress,
            'shcedule_datetime' =>  $scheduleDate,
            'technician_list'  =>  \App\Models\Technician::all(),
            'suppliers'        =>  \App\Models\Rfq::where('service_request_id', $service_request->id)->with('rfqSupplies', 'rfqSuppliesInvoices','rfqBatches', 'rfqSupplierDispatches', 'serviceRequest')->first(),
            'requestReports'  => \App\Models\ServiceRequestReport::where('service_request_id', $service_request->id)->latest('created_at')->get(),
            'RfqDispatchNotification' => $rfqWarranty? \App\Models\RfqDispatchNotification::where(['service_request_id' => $service_request->id, 'rfq_id'=>$rfq->id ])->get(): [],
            'causalAgent'  =>  $issued_id != '' ? \App\Models\ServiceRequestWarrantyReport::where([
                'service_request_warranties_issued_id' => $issued_id])->where('causal_agent_id', '!=', NULL)
                ->get(): [],
            'technicianExist' =>  $technicianExist,
             'rfqSupplierDispatch' => $rfqSupplierDispatch ,
            'causalTechnician' =>  count($causalTechnician) > 0 AND count($causalSuppliers) == 0 ? $causalTechnician: '0',
            'rfqDetails'    => $rfqWarranty? \App\Models\RfqSupplierInvoice::where(['rfq_id'=> $rfqWarranty->id])->where('accepted', '<>', 'No')
                            ->with('rfq', 'rfqBatches', 'supplier', 'supplierInvoiceBatches', 'supplierDispatch')->get(): null,
            'rfqWarranty' => $rfqWarranty,
            'rfqs'        =>  \App\Models\Rfq::where('service_request_id', $service_request->id)->with('rfqSupplies', 'rfqSuppliesInvoices','rfqBatches', 'rfqSupplierDispatches', 'serviceRequest')->get(),

        ];

  

       // dd($service_request->id, $rfq->id, $rfqWarranty,$variables['RfqDispatchNotification'] );
      
 
       
        if ($service_request->status_id == 2) {
            $service_request_progresses = \App\Models\ServiceRequestProgress::where('user_id', auth()->user()->id)->latest('created_at')->first();
            // Determine Ongoing Status List
            $variables = array_merge($variables, [
                'tools' => \App\Models\ToolInventory::all(),
                'latest_service_request_progress' => $service_request_progresses,
                'ongoingSubStatuses' => \App\Models\SubStatus::where('status_id', 2)
                    ->when($service_request_progresses->sub_status_id <= 13, function ($query, $sub_status) {
                        return $query->whereBetween('phase', [4, 9]);
                    }, function ($query) {
                        return $query->whereBetween('phase', [20, 27]);
                    })->get(['id', 'uuid', 'name']),
            ]);
            if ($service_request_progresses->sub_status_id >= 13) {
                // find the Issued RFQ
                $service_request->load(['rfqs' => function ($query) {
                    $query->where('status', 'Awaiting')->where('accepted', 'No')->with('rfqBatches', 'rfqSupplier', 'rfqSupplier.supplier')->first();
                }]);
            }
        }


        return view('cse.warranties.show', $variables);
    }

    public function subServiceDynamicFields(Request $request)
    {
        if ($request->ajax()) {
            (array) $filters = $request->only('sub_service_list');

            return view('cse.requests.includes._sub_service_dynamic_field', [
                'results'   =>  $filters ? \App\Models\SubService::select('name','uuid')->whereIn('uuid', $filters['sub_service_list'][0])->orderBy('name', 'ASC')->get() : []
            ]);
        }

    }

    public function see()
    {
   
        return view('emails.message',['mail_message' => '<p>nnnnnnnnnnnnnn</p>']);
    }
}
