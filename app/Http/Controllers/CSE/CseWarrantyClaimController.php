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


class CseWarrantyClaimController extends Controller
{
    use Loggable;

 public function accept_warranty_claim(Request $request,$language, $uuid){
  
  $warrantyExist = \App\Models\Warranty::where('id',  $uuid)->first();
  $serviceRequest = \App\Models\ServiceRequestWarranty::where('uuid', $uuid)->with('user.account', 'service_request', 'warranty')->first();
  $ifCsesAccept = \App\Models\ServiceRequestWarrantyIssued::where(['service_request_warranty_id' => $serviceRequest->id ])->first();

   if(!$ifCsesAccept){
    $warranty = \App\Models\ServiceRequestWarrantyIssued::create([
        'service_request_warranty_id'    =>  $serviceRequest->id,
        'cse_id'             =>  Auth::id(),            
    ]);
   }else{

    return back()->with('error', 'This warranty for job reference '.$serviceRequest->unique_id. 'has been accepted');

   }
   

    if ($warranty){
        $type = 'Others';
        $severity = 'Informational';
        $actionUrl = Route::currentRouteAction();
        $message = Auth::user()->email.' mark as resolved '. $serviceRequest->unique_id;
        $this->log($type, $severity, $actionUrl, $message);
        return redirect()->route('cse.warranty_claims_list', app()->getLocale())->with('success', $serviceRequest->unique_id.' warranty has been accepted successfully.');
       
    }
    else {
        $type = 'Errors';
        $severity = 'Error';
        $actionUrl = Route::currentRouteAction();
        $message = 'An Error Occured while '. Auth::user()->email. ' was trying to accept warranty for job reference '.$serviceRequest->unique_id;
        $this->log($type, $severity, $actionUrl, $message);
        return back()->with('error', 'An error occured while trying to accept warranty for job reference '.$serviceRequest->unique_id);
    }

 }
   
}
