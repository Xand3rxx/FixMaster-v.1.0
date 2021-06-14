<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class SchedulingDate
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
        array_push($actionable, self::build_scheduling_date($request, $service_request));
        return $actionable;
    }

    /**
     * Build Scheduling of Date for Client
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_scheduling_date(Request $request, ServiceRequest $service_request)
    {
        $request->validate(['preferred_time' => 'required|date']);
        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', '22821883-fc00-4366-9c29-c7360b7c2efc')->firstOrFail();
        return [
            'service_request_table' => [
                'service_request'       => $service_request,
                'preferred_time'        => $request->input('preferred_time'),
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
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' scheduled date for client on Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
    }
}
