<?php

namespace App\Http\Middleware;
use Closure;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequest;

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
               $serviceRequestId = $clientServiceRequest->id; // Service Request Id
               $serviceRequestUniqueId = $clientServiceRequest->unique_id; // Service Request UniqueId
               $serviceId = $clientServiceRequest->service_id; // Service Id
               $serviceRequestTotalAmt = $clientServiceRequest->total_amount;
               $serviceRequestClientId = $clientServiceRequest->client_id; // Service Request Client Id
               
                //trigger modal when this is true
                if ($clientServiceRequest->status_id == 4 && $clientServiceRequest->has_client_rated == "No") {
                           $request->merge([
                               'users' => $response,
                               'serviceRequestId' => $serviceRequestId,
                               'serviceId' => $serviceId,
                               'totalAmount' => $serviceRequestTotalAmt,
                               'unique_id' => $serviceRequestUniqueId
                               ]);
                           }

               // if the client skipped the rating, trigger the modal in the next period set here
                       if ($clientServiceRequest->status_id == 4 && $clientServiceRequest->has_client_rated == "Skipped" && $clientServiceRequest->updated_at < Carbon::now()->subMinutes(1)) {
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
