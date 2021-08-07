<?php

namespace App\Http\Controllers\ServiceRequest;

use RuntimeException;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\ServiceRequestSetting;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequestProgress;
use App\Http\Controllers\Messaging\MessageController;

class JobAcceptanceController extends Controller
{
    protected $assigned;
    protected $canAcceptJob;

    /**
     * Handle Job Acceptance from a Service Request Assignee
     *
     * @return void
     */
    public function __construct($service_request, $user)
    {
        $this->service_request = $service_request;
        $this->user = $user;
    }

    /**
     * Handle Job acceptance by cse 
     * 
     * @return \Illuminate\Http\Response
     */
    public function cseJobAcceptance()
    {
        (array)$canAcceptJob = $this->can_cse_accept_job();

        if ((bool)$canAcceptJob[0] == true) {
            return $this->handle_cse_accptance();
        }
        return back()->with('error', (string)$canAcceptJob[1]);
    }

    /**
     * Verify if CSE Can Accept Job.
     * 
     * @return array $response
     */
    protected function can_cse_accept_job()
    {
        (array)$response = [true, 'CSE Can accept Job'];
        // throw new RuntimeException('This CSE cannot accept new job at this moment');

        // Check if Job is available, 
        if (!($this->service_request->status_id == ServiceRequest::SERVICE_REQUEST_STATUSES['Pending'])) {
            return $response = [false, 'This Job is no more available'];
            //  Check if CSE number of ongoing jobs still permits accepting job
        } elseif (!(($count_of_ongoing_jobs = $this->user->cse->service_request_assgined->count()) < ServiceRequestSetting::latest('updated_at')->value('max_ongoing_jobs'))) {
            return $response = [false, 'You have a Maximum Number of Ongoing jobs of ' . $count_of_ongoing_jobs];
        }
        // Lock service request
        $this->service_request->lockForUpdate();
        // lock job to avoid another user working on this service request
        return $response;
    }

    /**
     * Handle Job Acceptance by CSE USER.
     */
    protected function handle_cse_accptance()
    {
        // 1. Find the sub status for cse job acceptance
        $sub_status = \App\Models\SubStatus::where('uuid', 'cee7aa41-2818-497b-98e2-b850a100741a')->firstOrFail();
        // Run DB Transaction to update all necessary records
        (bool) $assigned = false;
        DB::transaction(function () use ($sub_status, &$assigned) {
            // 1. Service Request Assigned Table create record: user_id, service_request_id, job_acceptance_time, status == active
            ServiceRequestAssigned::assignUserOnServiceRequest($this->user->id, $this->service_request->id, ServiceRequestAssigned::JOB_ACCEPTED[0], now(), ServiceRequestAssigned::STATUS[0], null, null, null, ServiceRequestAssigned::ASSISTIVE_ROLE[2]);
            // 2. Store Service request progress
            ServiceRequestProgress::storeProgress($this->user->id, $this->service_request->id, $sub_status->status_id, $sub_status->id);
            // 3. Update Service Request to Ongoing
            $this->service_request->update(['status_id' => $sub_status->status_id]);
            // ADMIN_CSE_JOB_ACCEPTANCE_NOTIFICATION
            $this->user->loadMissing('account');
            $this->service_request->loadMissing('client', 'address');

            $params = [
                'firstname' => $this->user->account->first_name,
                'lastname' => $this->user->account->last_name,
                'recipient_email' => $this->user->email,
                'recipient_email' => $this->user->email,
                'email' => $this->user->email,
                'cse_name' => $this->user->account->last_name . ' ' . $this->user->account->first_name,
                'job_ref' => $this->service_request->unique_id,
                'customer_name' => $this->service_request->client->account->last_name . ' ' . $this->service_request->client->account->first_name,
                'customer_email' => $this->service_request->client->email,
                'customer_phone' => $this->service_request->address->phone_number,
                'address' => $this->service_request->address->address,
                'url' => route('cse.requests.show', ['locale' => app()->getLocale(), 'request' => $this->service_request->uuid])
            ];
            \App\Traits\UserNotification::send($params, 'ADMIN_CSE_JOB_ACCEPTANCE_NOTIFICATION');
            // update registered to be true
            $assigned = true;
        });
        return $assigned == true
            ? redirect()->route('cse.requests.show', ['locale' => app()->getLocale(), 'request' => $this->service_request->uuid])->with('success', 'Job Accepted Successfully!')
            : back()->with('error', 'Error Aceepting this Job');
    }
}
