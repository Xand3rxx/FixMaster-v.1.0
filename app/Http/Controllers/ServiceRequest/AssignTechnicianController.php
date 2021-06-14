<?php

namespace App\Http\Controllers\ServiceRequest;

use Auth;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use App\Traits\findRecordWithUUID;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use App\Traits\Utility;
use Image;


class AssignTechnicianController extends Controller
{
    use findRecordWithUUID, Loggable, Utility;
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        // validate Request
        $this->validate($request, [
            'technician_user_uuid'  =>   'required|uuid|exists:users,uuid',
            'service_request_uuid' =>    'required|uuid|exists:service_requests,uuid'
        ]);
        return $this->assignTechnician($request) == true
            ? back()->with('success', 'Technician Assigned successfully!!')
            : back()->with('error', 'Error occured while assigning a technician');
    }

    public function handleAdditionalTechnician(Request $request)
    {
        return $this->assignTechnician($request);
    }

    /**
     * Update neccesary tables to assign the Technician to a service
     *
     * @param  \Illuminate\Http\Request     $request
     * 
     * @return \Illuminate\Http\Response
     */
    protected function assignTechnician(Request $request)
    {
        (bool) $registred = false;
        // 1. Find the Service Request ID from the UUID
        $serviceRequest = \App\Models\ServiceRequest::where('uuid', $request['service_request_uuid'])->with('users')->firstOrFail();
        // 2. Find the technician
        $technician = \App\Models\User::where('uuid', $request['technician_user_uuid'])->with('account')->firstOrFail();
        // 3. Confirm if Technician is already assigned
        if (collect($serviceRequest['users']->first(function ($user) use ($technician) {
            return $user->id == $technician->id;
        }))->isNotEmpty()) {
            return back()->with('error', $technician['account']['last_name'] . ' ' . $technician['account']['first_name'] . ' is already assigned to this Service Request');
        }
        // 4. Find the status for Assigning technician record
        $status = \App\Models\SubStatus::where('uuid', '1faffcc3-7404-4fad-87a7-97161d3b8546')->firstOrFail();

        // Run DB Transaction to update all necessary records after confirmation Technician is not already on the Service Request
        DB::transaction(function () use ($request, $serviceRequest, $technician, $status, &$registred) {
            // When preferred time is set
            $request->whenFilled('preferred_time', function () use ($request, $serviceRequest) {
                $serviceRequest->update(['preferred_time' => $request['preferred_time']]);
                $status = \App\Models\SubStatus::where('uuid', 'd258667a-1953-4c66-b746-d0c40de7189d')->firstOrFail();
                \App\Models\ServiceRequestProgress::storeProgress($request->user()->id, $serviceRequest->id, 2, $status->id);
            });

            // 1. Update the Service Request Status to Ongoing
            $serviceRequest->update(['status_id' => $status->status_id]);
            // 2. store in the service_request_assigned
            \App\Models\ServiceRequestAssigned::assignUserOnServiceRequest($technician->id, $serviceRequest->id);
            // 3. store in the service_request_progresses
            \App\Models\ServiceRequestProgress::storeProgress($request->user()->id, $serviceRequest->id, 2, $status->id);
            // 4. store in the activity log
            $this->log('request', 'Informational', Route::currentRouteAction(), $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' assigned ' . $technician['account']['last_name'] . ' ' . $technician['account']['first_name'] . ' (Technician) to ' . $serviceRequest->unique_id . ' Job.');
            // 5. notify the technicain in Email and In-app notification

            // 6. update registered to be true
            $registred = true;
        });
        return $registred;
    }

    public function assignWarrantyTechnician(Request $request){
       
    
        $this->validate(
            $request, 
           
            ['preferred_time' => 'required_if:service_request_warrant_issued_schedule_date,==,null'],
            ['required_if' => 'This scheduled fix date is required'],
         
        );
   
 
    
        $service_request_warranty_id = $request['service_request_warranty_id'];
        $serviceRequest = \App\Models\ServiceRequestWarrantyIssued::where('service_request_warranty_id', $request['service_request_warranty_id'])->first();
     
        if($request->intiate_rfq == 'no'){
       $done = $this->save($serviceRequest, $service_request_warranty_id,$request);

        if (  $done){
            $type = 'Others';
            $severity = 'Informational';
            $actionUrl = Route::currentRouteAction();
            $message = Auth::user()->email.' assigned new technician successfully ';
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('success','Assigned new technician successfully');

        }
        else {
            $type = 'Errors';
            $severity = 'Error';
            $actionUrl = Route::currentRouteAction();
            $message = 'An Error Occured while '. Auth::user()->email. ' was trying to assigned new technician ';
            $this->log($type, $severity, $actionUrl, $message);
            return back()->with('error', 'An error occurred while trying to assigned new technician ');
        }
    }
    }


    protected function save($serviceRequest, $service_request_warranty_id,$request ){
       
        $upload='1'; $comment='1';
      
        if($serviceRequest){
            $updateWarranty = \App\Models\ServiceRequestWarrantyIssued::where('service_request_warranty_id', $service_request_warranty_id)->update([
                    'service_request_warranty_id'     =>   $request['service_request_warranty_id'],
                    'cse_id'             =>  Auth::id(),
                    'technician_id'     =>   $request['technician_user_uuid'],
                    
                ]);

        }else{
       
            $createWarranty = \App\Models\ServiceRequestWarrantyIssued::create([
                    'service_request_warranty_id'        =>   $request['service_request_warranty_id'],
                    'cse_id'             =>  Auth::id(),
                    'technician_id'     =>   $request['technician_user_uuid'],
                    'scheduled_datetime' => $request->preferred_time,
                  

                ]);
        }
        $serviceRequestIssued = $serviceRequest??  $createWarranty;
    

        if($request->hasFile('upload_image')) {
            $upload = $this->upload_image($request,$serviceRequestIssued);
        }

        if($request->cse_comment) {
       $comment =  $this->diagnosticWarrantReport($request,$serviceRequestIssued);
        }
      
        if($upload  AND $comment){
            return true;

        }else{
            return false; 
        }
        
    }

    protected function upload_image($request,$serviceRequesIssued){
        foreach ($request->file('upload_image') as $file) {
            $image = $file;
            $imageName = (string) Str::uuid() .'.'.$file->getClientOriginalExtension();
            $imageDirectory = public_path('assets/warranty-claim-images').'/';
            $width = 350; $height = 259;
            Image::make($image->getRealPath())->resize($width, $height)->save($imageDirectory.$imageName);

            $createWarranty = \App\Models\ServiceRequestWarrantyImage::create([
                'user_id'                                         =>  Auth::id(),
                'service_request_warranties_issued_id'             =>  $serviceRequesIssued->id,
                'name'                                             =>   $imageName,
                
            ]);
    
        }
        return  $createWarranty ;
    }


    protected function diagnosticWarrantReport($request,$serviceRequesIssued){
        $createWarranty = \App\Models\ServiceRequestWarrantyReport::create([
            'user_id'                                         =>  Auth::id(),
            'service_request_warranties_issued_id'             =>  $serviceRequesIssued->id,
            'report'                                             =>   $request->cse_comment,
            
        ]);

        return  $createWarranty ;
    }


}

