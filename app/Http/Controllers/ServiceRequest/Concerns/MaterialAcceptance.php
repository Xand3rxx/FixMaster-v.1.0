<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Models\SubStatus;
use Illuminate\Http\Request;
use App\Models\ServiceRequest;

class MaterialAcceptance
{
    public $actionable;

    /**
     * Handle Material Acceptance 
     * 
     * @param  \Illuminate\Http\Request     $request
     * @param  \App\Models\ServiceRequest   $service_request
     * 
     * @return array $actionable
     */
    public static function handle(Request $request, ServiceRequest $service_request, array $actionable)
    {
        // Handle Material Status
        if ($request->filled('material_status')) {
            array_push($actionable, self::update_material_status($request, $service_request));
        }

        // Handle Accept Materials 
        if ($request->filled('material_accepted')) {
            array_push($actionable, self::update_accept_materials($request, $service_request));
        }

        return $actionable;
    }

    /**
     * Update Material Acceptance
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function update_material_status(Request $request, ServiceRequest $service_request)
    {
        // validate Request
        (array) $valid = $request->validate([
            'material_status'               =>  'bail|string|in:Awaiting,Shipped,Delivered',
        ]);
        // Updating rfq_supplier_dispatches to $valid['material_status']
        // Update RFQ Table Status colum with $valid['material_status']

        // $sub_status = SubStatus::where('uuid', '1abe702c-e6b1-422f-9145-810394f92e1d')->firstOrFail();
        $service_request->rfq->loadMissing(['rfqBatches.supplierInvoiceBatches', 'rfqSupplierInvoice.supplierDispatch']);

        return [
            'update_rfq_supplier_dispatches' => [
                'rfq_supplier_dispatches' => $service_request['rfq']['rfqSupplierInvoice']['supplierDispatch'],
                'cse_status'          => $valid['material_status'],
            ],
            'update_rfqs' => [
                'rfq'       => $service_request['rfq'],
                'status'    => $valid['material_status']
            ],
            'log' => [
                'type'                      =>  'request',
                'severity'                  =>  'informational',
                'action_url'                =>  \Illuminate\Support\Facades\Route::currentRouteAction(),
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . ' updated of the status of the Supplier Dispatch' . $service_request['rfq']['rfqSupplierInvoice']['supplierDispatch']['unique_id'] . ' for Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
    }

    /**
     * Update Material Acceptance
     * 
     * @throws \Illuminate\Validation\ValidationException
     * @return array
     */
    protected static function update_accept_materials(Request $request, ServiceRequest $service_request)
    {
        // validate Request
        (array) $valid = $request->validate([
            'material_accepted'               =>  'bail|string|in:Yes,No',
            'material_reason'               =>  'bail|required|string',
        ]);

        // Updating rfq_supplier_dispatches to $valid['material_status']
        // Update RFQ Table Status colum with $valid['material_status']

        $sub_status = SubStatus::where('uuid', $valid['material_accepted'] == 'Yes' ? '73c2b038-4127-4085-a407-f75152a02315' : '1d3baa2b-25ec-4790-937e-90cc6a625178')->firstOrFail();
        $service_request->rfq->loadMissing(['rfqBatches.supplierInvoiceBatches', 'rfqSupplierInvoice.supplierDispatch']);

        return [
            'update_rfq_supplier_dispatches' => [
                'rfq_supplier_dispatches' => $service_request['rfq']['rfqSupplierInvoice']['supplierDispatch'],
                'cse_material_acceptance'   => $valid['material_accepted'],
                'cse_comment'               => $valid['material_reason']
            ],
            'update_rfqs' => [
                'rfq'       => $service_request['rfq'],
                'accepted'    => $valid['material_accepted']
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
                'message'                   =>  $request->user()->account->last_name . ' ' . $request->user()->account->first_name . $valid['material_accepted'] == 'Yes' ? ' Accepted' : ' Declined' . '  the Supplier Dispatch' . $service_request['rfq']['rfqSupplierInvoice']['supplierDispatch']['unique_id'] . ' for Service Request:' . $service_request->unique_id . ' Job',
            ]
        ];
    }
}
