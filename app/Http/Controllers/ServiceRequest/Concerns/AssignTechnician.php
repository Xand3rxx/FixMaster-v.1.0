<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\Service;
use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestReport;

class AssignTechnician
{
    public $actionable;

    /**
     * Handle scheduling of date
     * 
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Models\ServiceRequest $service_request
     * 
     * @return array $actionable
     */
    public static function handle(Request $request, ServiceRequest $service_request, array $actionable)
    {
        array_push($actionable, self::build_initial_technician($request, $service_request));
        return $actionable;
    }

    /**
     * Build Scheduling of Date for Client
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_initial_technician(Request $request, ServiceRequest $service_request)
    {
        // dd($request->all(), 'sub_service');
        (array) $valid = $request->validate([
            'technician_user_uuid'      => 'required|uuid|exists:users,uuid',
        ]);
        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', '1faffcc3-7404-4fad-87a7-97161d3b8546')->firstOrFail();
        $user = \App\Models\User::where('uuid', $valid['technician_user_uuid'])->firstOrFail();

        return [
            'service_request_assigned' => [
                'user_id'                   => $user->id,
                'service_request_id'        => $service_request->id,
                'status'                    => null
            ],
            'service_request_progresses' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'status_id'            => $sub_status->status_id,
                'sub_status_id'        => $sub_status->id,
            ],
            'notification' => [
                'feature' => 'CUSTOMER_JOB_SCHEDULED_TIME_NOTIFICATION',
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
