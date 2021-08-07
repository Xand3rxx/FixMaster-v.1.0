<?php

namespace App\Http\Controllers\ServiceRequest\Concerns;

use App\Jobs\ServiceRequest\NotifySuppliers;
use App\Traits\Loggable;
use App\Models\ActivityLog;
use App\Models\ServiceRequest;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRequestReport;
use App\Models\ServiceRequestAssigned;
use App\Models\ServiceRequestProgress;

trait StoreInDatabase
{
    use Loggable;

    /**
     * Interact with savings of all action done inservice requests
     *
     * @param  array $parameters
     * 
     * @return boolean
     */
    public static function interactWithSaving(array $params)
    {
        return self::saveAction($params);
    }

    /**
     * Store details filled by the cse in the service request
     *
     * @param  array $parameters
     * 
     * @return boolean
     */
    protected static function saveAction(array $params)
    {
        (bool) $registred = false;
        // Run DB Transaction to update all necessary records after confirmation Technician is not already on the Service Request
        DB::transaction(function () use ($params, &$registred) {
            // dd($params, 'all parameters');
            foreach ($params as $table) {

                if (!empty($table['service_request_assigned'])) {
                    ServiceRequestAssigned::create($table['service_request_assigned']);
                    // Notify the User
                    \App\Traits\UserNotification::send($table['service_request_assigned']['notification']['params'], $table['service_request_assigned']['notification']['feature']);
                }

                if (!empty($table['trfs'])) {
                    // save on tool_requests
                    $tool_request = \App\Models\ToolRequest::create($table['trfs']);
                    foreach ($table['trfs']['tool_requests']['tool_id'] as $key => $tool_id) {
                        \App\Models\ToolRequestBatch::create([
                            'tool_request_id'  => $tool_request->id,
                            'tool_id'           => $tool_id,
                            'quantity'          => $table['trfs']['tool_requests']['tool_quantity'][$key],
                        ]);
                    }
                }

                if (!empty($table['rfqs'])) {
                    // save on rfqs table
                    $rfq = \App\Models\Rfq::create($table['rfqs']);
                    // save each of the component name on the rfqbatch table
                    foreach ($table['rfqs']['rfq_batches']['component_name'] as $key => $component_name) {
                        \App\Models\RfqBatch::create([
                            'rfq_id'                => $rfq->id,
                            'component_name'        => $component_name,
                            'manufacturer_name'     => $table['rfqs']['rfq_batches']['manufacturer_name'][$key],
                            'model_number'          => $table['rfqs']['rfq_batches']['model_number'][$key],
                            'quantity'              => $table['rfqs']['rfq_batches']['quantity'][$key],
                            'image'                 => $table['rfqs']['rfq_batches']['image'][$key]->store('public/assets/rfq-images'),
                            // 'image'                 => \App\Traits\ImageUpload::imageUploader($table['rfqs']['rfq_batches']['image'][$key],'assets/rfq-images'),
                            'unit_of_measurement'   => $table['rfqs']['rfq_batches']['unit_of_measurement'][$key] ?? "",
                            'size'                  => $table['rfqs']['rfq_batches']['size'][$key]
                        ]);
                    }
                    // $this->dispatch(new NotifySuppliers($table['rfqs']['service_request']));
                }

                if (!empty($table['invoice_building'])) {
                    \App\Traits\Invoices::completedServiceInvoice($table['invoice_building']['service_request'], $table['invoice_building']['estimated_work_hours']);
                }

                if (!empty($table['service_request_reports'])) {
                    ServiceRequestReport::create($table['service_request_reports']);
                }

                if (!empty($table['service_request_report'])) {
                    foreach ($table['service_request_report'] as $key => $report) {
                        ServiceRequestReport::create($report);
                    }
                }

                if (!empty($table['update_rfq_supplier_dispatches'])) {
                    $table['update_rfq_supplier_dispatches']['rfq_supplier_dispatches']->update($table['update_rfq_supplier_dispatches']);
                }
                if (!empty($table['update_rfqs'])) {
                    $table['update_rfqs']['rfq']->update($table['update_rfqs']);
                }

                if (!empty($table['service_request_table'])) {
                    $table['service_request_table']['service_request']->update($table['service_request_table']);
                }

                if (!empty($table['service_request_progresses'])) {
                    ServiceRequestProgress::create($table['service_request_progresses']);
                }

                if (!empty($table['add_technicians'])) {
                    foreach ($table['add_technicians'] as $key => $technician) {
                        ServiceRequestAssigned::create($technician);
                        // Notify the User
                        \App\Traits\UserNotification::send($technician['notification']['params'], $technician['notification']['feature']);
                    }
                }

                if (!empty($table['log'])) {
                    ActivityLog::create($table['log']);
                }

                if (!empty($table['notification'])) {
                    // Notify the User
                    \App\Traits\UserNotification::send($table['notification']['params'], $table['notification']['feature']);
                }
            }

            //   update registered to be true
            $registred = true;
        });
        return $registred;
    }
}
