<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\Service;
use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestReport;

class Categorization
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
        array_push($actionable, self::build_categorization($request, $service_request));
        return $actionable;
    }

    /**
     * Build Scheduling of Date for Client
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_categorization(Request $request, ServiceRequest $service_request)
    {
        // dd($request->all(), 'sub_service');
        (array) $valid = $request->validate([
            'category_uuid'         => 'required|uuid',
            'service_uuid'          => 'required|uuid',
            'sub_service_uuid'      => 'required|array',
            'sub_service_uuid.*'    => 'required|uuid|exists:sub_services,uuid',
            'other_comments'        => 'nullable',
        ]);
        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', 'd258667a-1953-4c66-b746-d0c40de7189d')->firstOrFail();
        $service = Service::where('uuid', $valid['service_uuid'])->firstOrFail();

        (array)$valid['sub_services'] = [];
        foreach ($valid['sub_service_uuid'] as $key => $sub_service_uuid) {
            array_push($valid['sub_services'], [
                'uuid' => $sub_service_uuid,
                'quantity' => 0
            ]);
        }

        $requiredArray = [
            'service_request_table' => [
                'service_request'   => $service_request,
                'service_id'        => $service->id,
                'sub_services'      => $valid['sub_services'],
            ],
            'service_request_progresses' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'status_id'            => $sub_status->status_id,
                'sub_status_id'        => $sub_status->id,
            ],
            // 'notification' => [
            //     'feature' => 'CUSTOMER_JOB_SCHEDULED_TIME_NOTIFICATION',
            // ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' scheduled date for client on Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
        if ($request->filled('other_comments')) {
            $otherComments = [
                'service_request_reports' => [
                    'user_id'              => $request->user()->id,
                    'service_request_id'   => $service_request->id,
                    'stage'                 => ServiceRequestReport::STAGES[0],
                    'type'                  => ServiceRequestReport::TYPES[2],
                    'report'                => $request->input('other_comments'),
                ]
            ];
            $requiredArray = array_merge($requiredArray, $otherComments);
        }
        return  $requiredArray;
    }
}
