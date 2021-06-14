<?php

namespace App\Http\Controllers\Technician;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\Loggable;
use Illuminate\Support\Facades\Route;
use Auth;
use Session;
use App\Models\PaymentDisbursed;
use App\Models\User;
use App\Models\ServiceRequest;
use App\Models\Status;
use App\Models\Bank;
use App\Models\ServiceRequestAssigned;
use App\Traits\PasswordUpdator;
use App\Traits\Utility;
use Illuminate\Support\Facades\Validator;

class TechnicianProfileController extends Controller
{
    use Loggable, PasswordUpdator, Utility;

     /* This method will redirect users back to the login page if not properly authenticated
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:web');
    }

    /**
     * Return Technician Dashboard
     */
    public function index()
    {
        $total_request =  ServiceRequestAssigned::where('user_id', Auth::id())->with('users', 'service_request')
            ->orderBy('created_at', 'DESC')->get();

        $ongoing_request = ServiceRequestAssigned::whereHas('service_request', function ($query) {
            $query->where('status_id', 2);
        })
            ->where('user_id', Auth::id())
            ->where('assistive_role', 'Technician')
            ->get();

        $completed_request = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 4);
        })
            ->where('user_id', Auth::id())
            ->where('assistive_role', 'Technician')
            ->get();

//        $ongoing_consultations = ServiceRequestAssigned::whereHas('service_request',function ($query) {
//            $query->where('status_id', 2);
//        })
//            ->where('user_id', Auth::id())
//            ->where('assistive_role', 'Technician')
//            ->get();

        $pending_consultations = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 1);
        })
            ->where('user_id', Auth::id())
            ->where('assistive_role', 'Technician')
            ->get();

        $completed_consultations = ServiceRequestAssigned::whereHas('service_request',function ($query) {
            $query->where('status_id', 4);
        })
            ->where('user_id', Auth::id())
            ->where('assistive_role', 'Technician')
            ->get();

        $payments = PaymentDisbursed::where('recipient_id', Auth::id())->get();

        //dd($data);
//        return ServiceRequestAssigned::with('users', 'service_request')->whereHas('service_request', function ($query) {
//            $query->where('status_id', 2);
//        })->where('user_id', Auth::id())
//            ->get();
//
//        return ServiceRequestAssigned::where('user_id', auth()->user()->id)
//            ->with(['service_request', 'service_request.users.roles', 'service_request.client','service_request.account'])
//            ->get();

        $data = compact(
            'total_request',
            'ongoing_request',
            'completed_request',
            'completed_consultations',
            'pending_consultations',
            'payments'

        );



        return view('technician.index', $data)->with('i');
    }

    public function newIndex()
    {

        return view('technician.newIndex')->with('i');
    }

    /**
     * Return Location Request Page
     */
    public function locationRequest()
    {

        return view('technician.location_request')->with('i');
    }

    /**
     * Return Payments Page
     */
    public function payments()
    {

        return view('technician.payments')->with('i');
    }

    /**
     * Return Service Requests Page
     */
    public function serviceRequests($language, ServiceRequestAssigned $serviceRequest)
    {


        $serviceRequests = ServiceRequestAssigned::where('user_id', Auth::id())->with('service_request')->get();

        return view('technician.requests', compact('serviceRequests'));
    }

    public function serviceRequestDetails($language, $details)
    {

        $serviceRequests = ServiceRequest::where('uuid', $details)->first();

        return view('technician.request_details', compact('serviceRequests'));

    }


    /**
     * Return View Profile Page
     */
    public function viewProfile(Request $request)
    {

        $user = User::where('id', Auth::id())->first();

        return view('technician.view_profile', compact('user'));
        //return view('technician.view_profile');
    }

    /**
     * Return Account Settings Page
     */
    public function editProfile(Request $request)
    {

        $result = User::findOrFail(Auth::id());

        $banks = Bank::get(['id', 'name']);

        return view('technician.edit_profile', compact('result', 'banks'));

    }

    public function updateProfile(Request $request)
    {
        $user = User::where('id', Auth::id())->first();

        if ($user->account->gender == "male") {
            $res = "his";
        } else {
            $res = "her";
        }

        $type = "Profile";
        $severity = "Informational";
        $actionUrl = Route::currentRouteAction();
        $message = $user->email . ' profile successfully updated ';
        $rules = [
            'first_name' => 'required|max:255',
            'middle_name' => 'required|max:255',
            'last_name' => 'required|max:255',
            'gender' => 'required|max:255',
            'email' => 'required|email',
            'phone_number' => 'required',
            'profile_avater' => 'mimes:jpeg,jpg,png,gif',
            'full_address' => 'required',


        ];

        $messages = [
            'first_name.required' => 'First Name field can not be empty',
            'middle_name.required' => 'Middle Name field can not be empty',
            'last_name.required' => 'Last Name field can not be empty',
            //  'profile_avater.required' => '',
            'gender.required' => 'Please select gender',
            'email.required' => 'Email field can not be empty',
            'phone_number.required' => 'Please select phone number',
            'profile_avater.mimes'    => 'Unsupported Image Format',

        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withInput()->withErrors($validator);
        } else {

            if ($request->hasFile('profile_avater')) {
                $filename = $request->profile_avater->getClientOriginalName();
                $request->profile_avater->move('assets/user-avatars', $filename);
            } else {
                $filename = $user->account->avatar;
            }

            $user->account->update([
                'user_id' => $user->id,
                'first_name' => $request->first_name,
                'middle_name' => $request->middle_name,
                'last_name' => $request->last_name,
                'gender' => $request->gender,
                'bank_id' => $request->bank_id,
                'account_number' => $request->account_number,
                'avatar' => $filename
            ]);


            $user->update([
                'email' => $request->email,
            ]);

            $user->contact->update([
                'user_id' => $user->id,
                'phone_number' => $request->phone_number,
                'address' => $request->full_address,
            ]);



            $this->log($type, $severity, $actionUrl, $message);

            return redirect()->back()->with('success', 'Your profile has been updated successfully');
        }
    }




    /**
     * Update password of the current request user
     *
     * PLEASE INCLUDE IN FORM REQUEST THE NAME:
     *
     * 1: current_password
     *
     * 2: new_password
     *
     * 3: new_confirm_password
     *
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function updatePassword(Request $request)
    {
        return $this->passwordUpdator($request);
    }

    public function get_technician_disbursed_payments(Request $request){

        $years =  $this->getDistinctYears($tableName = 'payments_disbursed');

        $payments = PaymentDisbursed::where('recipient_id', Auth::id())->with('user')->get();
       // $payments = PaymentDisbursed::where('recipient_id',Auth::id())
       // ->orderBy('created_at', 'DESC')->get();
        return view('technician.payments', compact('payments', 'years'));
    }

    public function sortDisbursedPayments(Request $request){
        if($request->ajax()){

            // return $request;
            //Get current activity sorting level
            $level =  $request->get('sort_level');
            //Get the activity sorting type
            $type =  $request->get('type');
            //Get activity log for a specific date
            $specificDate =  $request->get('date');
            //Get activity log for a specific year
            $specificYear =  $request->get('year');
            //Get activity log for a specific month
            $specificMonth =  date('m', strtotime($request->get('month')));
            //Get activity log for a specific month name
             $specificMonthName =  $request->get('month');
            //Get activity log for a date range
            $dateFrom =  $request->get('date_from');
            $dateTo =  $request->get('date_to');

            if($level === 'Level One'){

                $payments = PaymentDisbursed::where('type', $type)
                ->orderBy('created_at', 'DESC')->get();

                $message = 'Showing Disbursed Payment of "'.$type.'"';

                return view('technician._disbursed_table', compact('payments','message'));
            }

            if($level === 'Level Two'){

                if(!empty($specificDate)){
                    $payments = PaymentDisbursed::whereDate('created_at', $specificDate)
                    ->where('recipient_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments for '.\Carbon\Carbon::parse($specificDate, 'UTC')->isoFormat('LL');
                }

                return view('technician._disbursed_table', compact('payments','message'));

            }

            if($level === 'Level Three'){

                if(!empty($specificYear)){
                    $payments = PaymentDisbursed::whereYear('created_at', $specificYear)
                    ->where('recipient_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments for year '.$specificYear;
                }

                return view('technician._disbursed_table', compact('payments','message'));
            }

            if($level === 'Level Four'){

                if(!empty($specificYear) && !empty($specificMonth)){
                    $payments = PaymentDisbursed::whereYear('created_at', $specificYear)
                    ->whereMonth('created_at', $specificMonth)
                    ->where('recipient_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments for "'.$specificMonthName.'" in year '.$specificYear;
                }

                return view('technician._disbursed_table', compact('payments','message'));
            }

            if($level === 'Level Five'){

                if(!empty($dateFrom) && !empty($dateTo)){
                    $payments = PaymentDisbursed::whereBetween('created_at', [$dateFrom, $dateTo])
                    ->where('recipient_id', Auth::id())
                    ->orderBy('created_at', 'DESC')->get();

                    $message = 'Showing Disbursed Payments from "'.\Carbon\Carbon::parse($dateFrom, 'UTC')->isoFormat('LL').'" to "'.\Carbon\Carbon::parse($dateTo, 'UTC')->isoFormat('LL').'"';
                }

                 return view('technician._disbursed_table', compact('payments','message'));
            }
        }
    }

    public function paymentHistory(Request $request){

        $years =  $this->getDistinctYears($tableName = 'payments_disbursed');

        $payments = PaymentDisbursed::where('recipient_id', Auth::id())->with('user')->get();
        // $payments = PaymentDisbursed::where('recipient_id',Auth::id())
        // ->orderBy('created_at', 'DESC')->get();
        return view('technician.payment_history', compact('payments', 'years'));
    }
}
