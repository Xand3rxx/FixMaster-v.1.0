<?php

namespace App\Http\Middleware;
use Closure;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestPayment;

class CheckClientRating
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
    
    $output = ServiceRequest::where('client_id', Auth::id())->with('users', 'users.roles')->get();

           foreach ($output as $clientServiceRequest) {
               $response = $clientServiceRequest->users;
               $serviceRequestId = $clientServiceRequest->id;
               $serviceRequestUniqueId = $clientServiceRequest->unique_id;
               $serviceId = $clientServiceRequest->service_id; 
               $serviceRequestTotalAmt = $clientServiceRequest->total_amount;
               $serviceRequestClientId = $clientServiceRequest->client_id;
               
               $servicePay = ServiceRequestPayment::where('user_id', Auth::id())
               ->where('service_request_id', $serviceRequestId)
               ->where('payment_type', 'diagnosis-fee')
               ->orWhere('payment_type', 'final-invoice-fee')->where('status','success')->first();

               //Trigger for Client Diagnosis Rating's Modal
               if(!empty($servicePay) && $servicePay->payment_type == "diagnosis-fee" && $clientServiceRequest->client_diagnosis_rating == "No"){
                $request->merge([
                    'group' => $response,
                    'serviceRequestId' => $serviceRequestId,
                    'serviceId' => $serviceId,
                    'total_Amount' => $serviceRequestTotalAmt,
                    //'service_Id' => $serviceId,
                    'uniqueId' => $serviceRequestUniqueId    
                    ]);
               }
                
              // if the client skipped the rating, trigger the modal in the next period set here
               if(!empty($servicePay) && $servicePay->payment_type == "diagnosis-fee" && $clientServiceRequest->client_diagnosis_rating == "Skipped" && $clientServiceRequest->diagnosis_rated_at < Carbon::now()->subMinutes(1)){
                $request->merge([
                    'group' => $response,
                    'serviceRequestId' => $serviceRequestId,
                    'serviceId' => $serviceId,
                    'total_Amount' => $serviceRequestTotalAmt,
                    'uniqueId' => $serviceRequestUniqueId
                    ]);
               }

                //Trigger for Client's service completion Rating's Modal
                if ($clientServiceRequest->status->name == "Completed" &&!empty($servicePay) && $servicePay->payment_type == "final-invoice-fee" && $clientServiceRequest->has_client_rated == "No") {
                           $request->merge([
                               'users' => $response,
                               'serviceRequestId' => $serviceRequestId,
                               'serviceId' => $serviceId,
                               'totalAmount' => $serviceRequestTotalAmt,
                               'unique_id' => $serviceRequestUniqueId,
                               ]);
                           }

               // if the client skipped the rating, trigger the modal in the next period set here
                       if ($clientServiceRequest->status->name == "Completed" &&!empty($servicePay) && $servicePay->payment_type == "final-invoice-fee" && $clientServiceRequest->has_client_rated == "Skipped" && $clientServiceRequest->updated_at < Carbon::now()->subMinutes(1)) {
                        $request->merge([
                        'users' => $response,
                        'serviceRequestId' => $serviceRequestId,
                        'serviceId' => $serviceId,
                        'totalAmount' => $serviceRequestTotalAmt,
                        'unique_id' => $serviceRequestUniqueId
                        ]);
                    }


                  }

        return $next($request);
    }
}
