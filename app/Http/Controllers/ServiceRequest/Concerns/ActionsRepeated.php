<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\Rfq;
use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestReport;
use App\Models\ServiceRequestAssigned;

class ActionsRepeated
{
    public $repeated_actions;

    /**
     * Handle repated Actions on a Service Request
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\ServiceRequest $service_request
     * 
     * @return array $repeated_actions
     */
    public static function handle(Request $request, ServiceRequest $service_request, array $repeated_actions)
    {
        // Handle Add Comment
        if ($request->filled('add_comment')) {
            array_push($repeated_actions, self::build_comment($request, $service_request));
        }

        // Handle Request for QA
        if ($request->filled('qa_user_uuid')) {
            array_push($repeated_actions, self::build_requesting_qa($request, $service_request));
        }

        // Handle Assign a Technician
        if ($request->filled('add_technician_user_uuid')) {
            array_push($repeated_actions, self::build_assign_technician($request, $service_request));
        }

        return $repeated_actions;
    }

    /**
     * Build Comment to be added to database
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_comment(Request $request, ServiceRequest $service_request)
    {
        $request->validate(['add_comment' => 'required|string']);
        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', 'ab43a32e-709e-4bf9-bba2-78828d2cfda9')->firstOrFail();
        return [
            'service_request_reports' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'stage'                 => ServiceRequestReport::STAGES[0],
                'type'                  => ServiceRequestReport::TYPES[2],
                'report'                => $request->input('add_comment'),
            ],
            'service_request_progresses' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'status_id'            => $sub_status->status_id,
                'sub_status_id'        => $sub_status->id,
            ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' added comment to ' . $service_request->unique_id . ' Job',
            ]
        ];
    }

   

    /**
     * Build New Tools Request to be added to database
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_requesting_qa(Request $request, ServiceRequest $service_request)
    {
        // validate Request
        (array) $valid = $request->validate([
            'qa_user_uuid'      => 'required|uuid|exists:users,uuid',
        ]);

        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', 'e59c3305-45ce-4d8e-b5ab-a5f4e9d40aca')->firstOrFail();
        $user = \App\Models\User::where('uuid', $valid['qa_user_uuid'])->with('account')->firstOrFail();
        $service_request->loadMissing('service', 'status');
        return [
            'service_request_assigned' => [
                'user'                      => $user,
                'user_id'                   => $user->id,
                'service_request_id'        => $service_request->id,
                'assistive_role'            => ServiceRequestAssigned::ASSISTIVE_ROLE[1],
                'status'                    => null,
                'notification' => [
                    'feature' => 'CSE_ASSIGNED_QA_TO_A_JOB',
                    'params'    => [
                        'cse_name'  => $request->user()->account->last_name .' '.$request->user()->account->first_name,
                        'cse_email' =>  $request->user()->email,
                        'cse_phone' => $request->user()->contact->phone_number,
                        'service_category' => $service_request->service->category->name,
                        'job_status'    =>  $service_request->status->name,
                        'qa_name'   => $user['account']['last_name'] .' '.$user['account']['first_name'],
                        'lastname' => $user['account']['last_name'],
                        'firstname' => $user['account']['first_name'],
                        'recipient_email' => $user['email'],
                        'job_ref' =>  $service_request->unique_id
                    ]
                ],
            ],
            'service_request_progresses' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'status_id'            => $sub_status->status_id,
                'sub_status_id'        => $sub_status->id,
            ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' requested a new Quality Assurance for Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
    }

    /**
     * Build New Tools Request to be added to database
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_assign_technician(Request $request, ServiceRequest $service_request)
    {
        // validate Request
        (array) $valid = $request->validate([
            'add_technician_user_uuid'        => 'required|array',
            'add_technician_user_uuid.*'      => 'required|uuid|exists:users,uuid',
        ]);

        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', '1faffcc3-7404-4fad-87a7-97161d3b8546')->firstOrFail();
        $valid['technicians'] = [];

        foreach ($valid['add_technician_user_uuid'] as $key => $technician) {
            $user = \App\Models\User::where('uuid', $technician)->with('account')->firstOrFail();
            array_push($valid['technicians'], [
                'user_id'                   => $user->id,
                'service_request_id'        => $service_request->id,
                'status'                    => null,
                'notification' => [
                    'feature' => 'CSE_ASSIGNED_TECHNICIAN_TO_A_JOB',
                    'params'    => [
                        'lastname' => $user['account']['last_name'],
                        'firstname' => $user['account']['first_name'],
                        'recipient_email' => $user['email'],
                        'job_ref' =>  $service_request->unique_id
                    ]
                ],
            ]);
        }

        return [
            'add_technicians' => $valid['technicians'],
            'service_request_progresses' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'status_id'            => $sub_status->status_id,
                'sub_status_id'        => $sub_status->id,
            ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' assigned a new Technician for Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
    }
}
