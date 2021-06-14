<?php

namespace App\Http\Controllers\ServiceRequest;

use App\Traits\Invoices;
use App\Traits\Loggable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

class ProjectProgressController extends Controller
{
    use Loggable, Invoices;

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
            'sub_status_uuid'       =>  'bail|required|string|uuid',
            'service_request_uuid'  =>  'required|string|uuid|exists:service_requests,uuid',
            'technician_user_uuid'  =>  'sometimes|nullable|uuid|exists:users,uuid',
            'accept_materials'      =>  'sometimes|nullable',
        ]);

        $request->whenFilled('technician_user_uuid', function () use ($request) {
            $assignTechnician =  new AssignTechnicianController();
            $assignTechnician->handleAdditionalTechnician($request);
        });

        return $this->updateProjectProgress($request);
    }

    /**
     * Update the Project progress 
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function updateProjectProgress(Request $request)
    {
        // 1. Find the Service Request ID from the UUID
        $serviceRequest = \App\Models\ServiceRequest::where('uuid', $request['service_request_uuid'])->firstOrFail();
        //  2. Find the Substatus selected 
        $substatus = \App\Models\SubStatus::where('uuid', $request['sub_status_uuid'])->firstOrFail();

        if ($substatus->phase === 9) {
            return $this->handleCompletedDiagnosis($request, $serviceRequest, $substatus);
        }

        // Check if Completed diagnosis, then transfer to Isaac Controller
        if ($request['intiate_rfq'] == 'yes') {
            $this->handleRFQ($request, $serviceRequest);
        }

        if ($request['intiate_trf'] == 'yes') {
            $this->handleToolsRequest($request, $serviceRequest);
        }


        $request->whenFilled('accept_materials', function () use ($request, $serviceRequest) {

            $this->handleMaterialsAcceptance($request, $serviceRequest);
        });

        return $this->updateDatabase($request->user(), $serviceRequest, $substatus);
    }

    /**
     * Handle Completed Diagnosis
     *
     * @param  \Illuminate\Http\Request     $request
     * @param  \App\Models\ServiceRequest   $serviceRequest
     * @param  \App\Models\SubStatus        $substatus
     * 
     * 
     * @return \Illuminate\Http\Response
     */
    protected function handleCompletedDiagnosis(Request $request, \App\Models\ServiceRequest $serviceRequest, \App\Models\SubStatus $substatus)
    {
        $completedDiagnosis =  new HandleCompletedDiagnosisController();
        return $completedDiagnosis->generateDiagnosisInvoice($request, $serviceRequest, $substatus);
    }

    /**
     * Handle Completed Diagnosis
     *
     * @param  \App\Models\User $user
     * @param  \App\Models\ServiceRequest $serviceRequest
     * @param  \App\Models\SubStatus $substatus
     * 
     * @return \Illuminate\Http\Response
     */
    protected function updateDatabase(\App\Models\User $user, \App\Models\ServiceRequest $serviceRequest, \App\Models\SubStatus $substatus)
    {
        // Run DB Transaction to update all necessary records
        (bool) $registred = false;

        DB::transaction(function () use ($user, $serviceRequest, $substatus, &$registred) {
            // store in the service_request_progresses
            \App\Models\ServiceRequestProgress::storeProgress($user->id, $serviceRequest->id, $substatus->status_id, $substatus->id);
            // store in the activity log
            $this->log('request', 'Informational', Route::currentRouteAction(), $user->account->last_name . ' ' . $user->account->first_name . ' ' . $substatus->name . ' for (' . $serviceRequest->unique_id . ') Job.');
            // notify the technicain in Email and In-app notification
            // $message = new \App\Http\Controllers\Messaging\MessageController();

            // update registered to be true
            $registred = true;
        });
        return $registred == true
            ? back()->with('success', 'Project Progress successfully!!')
            : back()->with('error', 'Error occured while updating project progress');
    }

    /**
     * Handle generated RFQ 
     *
     * @param  \App\Models\ServiceRequest $serviceRequest
     * @param  \Illuminate\Http\Request     $request
     * 
     * @return \Illuminate\Http\Response
     */
    protected function handleRFQ(Request  $request, \App\Models\ServiceRequest $serviceRequest)
    {
        // validate Request
        (array) $valid = $this->validate($request, [
            'intiate_rfq'               => 'bail|string|in:yes,no',
            'component_name'            => 'bail|sometimes|required_unless:intiate_rfq,no|array',
            'component_name.*'          => 'bail|sometimes|required_unless:intiate_rfq,no|nullable',
            'model_number'              => 'bail|sometimes|required_unless:intiate_rfq,no|array',
            'model_number.*'            => 'bail|sometimes|required_unless:intiate_rfq,no|nullable',
            'quantity'                  => 'bail|sometimes|required_unless:intiate_rfq,no|array',
            'quantity.*'                => 'bail|sometimes|required_unless:intiate_rfq,no|nullable',
        ]);

        // save to 1. rfqs 2. rfq_batches
        DB::transaction(function () use ($valid, $serviceRequest) {
            // save on rfqs table
            $rfq = \App\Models\Rfq::create([
                'issued_by' => auth()->user()->id,
                'client_id' => $serviceRequest->client_id,
                'service_request_id'    => $serviceRequest->id,
            ]);
            // save each of the component name on the rfqbatch table
            foreach ($valid['component_name'] as $key => $component_name) {
                \App\Models\RfqBatch::create([
                    'rfq_id'           => $rfq->id,
                    'component_name'    => $component_name,
                    'model_number'      => $valid['model_number'][$key],
                    'quantity'          => $valid['quantity'][$key],
                    'amount'            => 0.00,
                ]);
            }
            $this->rfqInvoice($serviceRequest->id, $rfq->id);
            $this->log('request', 'Informational', \Illuminate\Support\Facades\Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . ') Job.');
        });
        return true;
    }

    /**
     * Handle generated Tools Request
     *
     * @param  \App\Models\ServiceRequest   $serviceRequest
     * @param  \Illuminate\Http\Request     $request
     * 
     * @return \Illuminate\Http\Response
     */
    protected function handleToolsRequest(Request $request, \App\Models\ServiceRequest $serviceRequest)
    {
        // validate Request
        (array) $valid = $this->validate($request, [
            'intiate_trf'               =>  'bail|string|in:yes,no',
            'tool_id'                   =>  'bail|sometimes|required_unless:intiate_trf,no|array',
            'tool_id.*'                 =>  'bail|sometimes|required_unless:intiate_rfq,no|nullable',
            'tool_quantity'             =>  'bail|sometimes|required_unless:intiate_trf,no|array',
            'tool_quantity.*'           =>  'bail|sometimes|required_unless:intiate_rfq,no|nullable',
        ]);

        // save to 1. rfqs 2. rfq_batches
        DB::transaction(function () use ($valid, $serviceRequest) {
            // save on the tools requests table
            $toolsRequest = \App\Models\ToolRequest::create([
                'requested_by' => auth()->user()->id,
                'client_id' => $serviceRequest->client_id,
                'service_request_id'    => $serviceRequest->id,
            ]);
            // save each of the component name on the tool_request_batches table
            foreach ($valid['tool_id'] as $key => $tool_id) {
                \App\Models\ToolRequestBatch::create([
                    'tool_request_id'  => $toolsRequest->id,
                    'tool_id'           => $tool_id,
                    'quantity'          => $valid['tool_quantity'][$key],
                ]);
            }
            $this->log('request', 'Informational', Route::currentRouteAction(), auth()->user()->account->last_name . ' ' . auth()->user()->account->first_name  . 'Requested for Tools.');
        });
        return true;
    }

    /**
     * Handle Materials Acceptance
     *
     * @param  \App\Models\ServiceRequest   $serviceRequest
     * @param  \Illuminate\Http\Request     $request
     * 
     * @return \Illuminate\Http\Response
     */
    protected function handleMaterialsAcceptance(Request $request, \App\Models\ServiceRequest $serviceRequest)
    {
        return $serviceRequest['rfqs']->where('status', 'Awaiting')->where('accepted', 'No')->first()->update(['status' => $request['accept_materials'] == 'No' ? 'Rejected' : 'Delivered', 'accepted' => $request['accept_materials']]);
    }
}
