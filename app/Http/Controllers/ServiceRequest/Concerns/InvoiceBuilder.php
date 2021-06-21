<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\Service;
use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;
use App\Models\ServiceRequestReport;

class InvoiceBuilder
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
        // Handle RFQ
        if ($request->filled('intiate_rfq') && ($request->input('intiate_rfq') == 'yes')) {
            array_push($actionable, self::build_new_rfq($request, $service_request));
        }

        // Handle Tool Request
        if ($request->filled('intiate_trf') && ($request->input('intiate_trf') == 'yes')) {
            array_push($actionable, self::build_new_trf($request, $service_request));
        }

        array_push($actionable, self::build_invoice($request, $service_request));
        return $actionable;
    }

    /**
     * Build Scheduling of Date for Client
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_invoice(Request $request, ServiceRequest $service_request)
    {
        (array) $valid = $request->validate([
            'estimated_work_hours'  => 'required|numeric',
            'quantity'              => 'required|array',
            'quantity.*'            => 'sometimes',
            'root_cause'            => 'required|string',
            'other_comments'        => 'nullable',
        ]);

        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', 'f95c31c6-6667-4a64-bee3-8aa4b5b943d3')->firstOrFail();
        $valid['sub_services'] = [];
        foreach ($valid['quantity'] as $key => $quantity) {
            if (!empty($quantity)) {
                array_push($valid['sub_services'], [
                    'uuid' => $key,
                    'quantity' => $quantity
                ]);
            }
        }
        $requiredArray = [
            'service_request_table' => [
                'service_request'   => $service_request,
                'service_id'        => $service_request->service_id,
                'sub_services'      => $valid['sub_services'],
            ],
            'invoice_building'      => [
                'estimated_work_hours' => $valid['estimated_work_hours'],
                'service_request'      => $service_request
            ],
            'service_request_report' => [],
            'service_request_progresses' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'status_id'            => $sub_status->status_id,
                'sub_status_id'        => $sub_status->id,
            ],
            // 'notification' => [
            //     'feature' => 'CUSTOMER_JOB_SCHEDULED_TIME_NOTIFICATION',
            //     'params'  => [
            //         // customer_name
            //         // cse_name
            //         // date
            //         // technician_name
            //         // technician_id
            //         // 'email' => customer_email
            //     ]
            // ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' cse generated invoice on Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
        array_push($requiredArray['service_request_report'], [
            'user_id'              => $request->user()->id,
            'service_request_id'   => $service_request->id,
            'stage'                 => ServiceRequestReport::STAGES[0],
            'type'                  => ServiceRequestReport::TYPES[0],
            'report'                => $request->input('root_cause'),
        ]);
        if ($request->filled('other_comments')) {
            array_push($requiredArray['service_request_report'], [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'stage'                => ServiceRequestReport::STAGES[0],
                'type'                 => ServiceRequestReport::TYPES[2],
                'report'               => $request->input('other_comments'),
            ]);
        }
        return  $requiredArray;
    }

    /**
     * Build New RFQ to be added to database
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_new_rfq(Request $request, ServiceRequest $service_request)
    {
        // validate Request
        (array) $valid = $request->validate([
            'intiate_rfq'               => 'bail|string|in:yes,no',

            'manufacturer_name'         => 'bail|required|array',
            'manufacturer_name.*'       => 'required|string',

            'model_number'              => 'bail|required|array',
            'model_number.*'            => 'required|string',

            'component_name'            => 'bail|required|array',
            'component_name.*'          => 'required|string',

            'quantity'                  => 'bail|required|array',
            'quantity.*'                => 'required|string',

            'image'                     => 'bail|required|array',
            'image.*'                   => 'bail|required|image',

            'unit_of_measurement'       => 'bail|sometimes|array|nullable',
            'unit_of_measurement.*'     => 'nullable',

            'size'                      => 'bail|required|array',
            'size.*'                    => 'nullable',
        ]);


        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', '2df4da1e-6c07-402c-a316-0378d37e50a1')->firstOrFail();

        return [
            'rfqs' => [
                // save on rfqs table
                'issued_by'             => $request->user()->id,
                'service_request_id'    => $service_request->id,
                'type'                  => \App\Models\Rfq::TYPES[0],
                'rfq_batches' => $valid,
            ],

            'service_request_progresses' => [
                'user_id'              => $request->user()->id,
                'service_request_id'   => $service_request->id,
                'status_id'            => $sub_status->status_id,
                'sub_status_id'        => $sub_status->id,
            ],
            // 'notifications' => [
            //     'feature' => 'CUSTOMER_JOB_SCHEDULED_TIME_NOTIFICATION',
            //     'data'  => [
            //         'supplier_business_name',
            //         'url',
            //         'user_first_name',
            //         'user_last_name',
            //         // 'lastname' => $account['last_name'],
            //     ]
            // ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' issued an RFQ for Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
    }

    /**
     * Build New Tools Request to be added to database
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function build_new_trf(Request $request, ServiceRequest $service_request)
    {
        // dd($request->all(), 'intiate_trf');
        // validate Request
        (array) $valid = $request->validate([
            'intiate_trf'               =>  'bail|string|in:yes,no',
            'tool_id'                   =>  'bail|required|array',
            'tool_id.*'                 =>  'bail|string',
            'tool_quantity'             =>  'bail|required|array',
            'tool_quantity.*'           =>  'bail|numeric',
        ]);

        // Each Key should match table names, value match accepted parameter in each table name stated
        $sub_status = SubStatus::where('uuid', '1abe702c-e6b1-422f-9145-810394f92e1d')->firstOrFail();

        return [
            'trfs' => [
                'requested_by'          => $request->user()->id,
                'service_request_id'    => $service_request->id,
                'tool_requests' => $valid,
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
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' issued a new Tool Request for Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
    }
}
