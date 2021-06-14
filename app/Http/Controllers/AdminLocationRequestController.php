<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL; 
// use Route;
use Auth;
use App\Models\User;
// use App\Http\Controllers\RecordActivityLogController; 
use App\Models\Location; 
use App\Models\ServiceRequest;
use DB;
// use App\Models\Name;



class AdminLocationRequestController extends Controller
{
    /**
     * This method will redirect users back to the login page if not properly authenticated
     * @return void
     */  
    // public function __construct() {
    //     $this->middleware('auth:web');
    // }


// use App\Models\User;
// use App\Models\CSE;

//         $cse = CSE::where('user_id', Auth::id())->first();
//         $serviceRequests = $cse->requests;
//         $ongoingJobs = $cse->requests()
//                 ->where('service_request_status_id', '>', '3')
//                 ->get();


// public function ongoingRequests(){

//     $serviceRequests = ServiceRequest::OngoingRequests()->get();

//     $createdBy = Name::get();

//     $data = [
//         'serviceRequests'   =>  $serviceRequests,
//         'createdBy'         =>  $createdBy,
//     ];

//     return view('admin.requests.requests_ongoing', $data)->with('i');
// }


    public function index()
    {
        $data['serviceRequests'] = ServiceRequest::where('status_id', 2)
                                    // ->with('serviceRequestAssigned')
                                    ->get(); 
                                    
        $locationRequest = Location::get();
        // $serviceRequests = ServiceRequest::where('id', 4)->get();
        // $createdBy    = Name::get();

        // $createdBy    = Name::get(); ->with('users')


        // $data = [
        //     'locationRequest'   =>  $locationRequest, 
        //     'serviceRequests'   =>  $serviceRequests,
        //     // 'createdBy'         =>  $createdBy
        // ];

        // echo '<pre>';  $data['client']->user->phones[0]->number
        // dd($data['serviceRequests']);
        // echo '<pre>';

        return view('admin.location.location_request', $data)->with('i');

    }

        // this method is used to fetch a single menu item
        public function getUsersAssigned($id) {
            $data = Account::where("user_id", 2)->get();
            return $data;
        }

    // public function getRecipientNames(Request $request){
    //     // $locationRequest = Location::get();
    //     // $serviceRequests = ServiceRequest::OngoingRequests()->get();
    //     $recipient_id = Name::findOrFail($request->selectedReciever);
    //     $data = [
    //         // 'locationRequest'   =>  $locationRequest, 
    //         // 'serviceRequests'   =>  $serviceRequests,
    //         'recipient_id'        =>  $recipient_id
    //     ];
    //     return view('admin.location.location_request', $data)->with('i');

    // }





    // public function getNames(Request $request){
    //     // $locationRequest = Location::get();
    //     // $serviceRequests = ServiceRequest::OngoingRequests()->get();
    //     $recipient_id = Name::findOrFail($request->selectedReciever);
    //     $data = [
    //         // 'locationRequest'   =>  $locationRequest, 
    //         // 'serviceRequests'   =>  $serviceRequests,
    //         'recipient_id'        =>  $recipient_id
    //     ];
    //     return view('admin.location.location_request', $data)->with('i');

    // }

    public function requestLocation(Request $request){
        $location = new Location;
        $location->requester_id = Auth::id();
        $location->recipient_id = $request->subject; 
        $location->location = $request->message;
        $location->job_reference = $request->message;
        $location->service_id = $request->message;
        // $location->status = is '1' by default
        $saveLocation = $location->save();
    }

    
}
