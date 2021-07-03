<div id="serviceRequestSummary" class="tab-pane pd-20 pd-xl-25">
    @if(count($service_request['serviceRequestReports']) > 0)
    <div class="divider-text"> Reports/Comments</div>
    <div class="card-grou">
        @foreach ($service_request['serviceRequestReports'] as $report)
            <div class="card row">
                <div class="card-body shadow-none bd-primary overflow-hidden">
                <div class="marker-primary marker-ribbon pos-absolute t-10 l-0">{{ $loop->iteration }}</div>
                <h4>{{ $report['type'] }}</h4>
                    <p class="card-text">{{ $report['report'] }}</p>
                    <p class="card-text"><small class="text-muted">Date Created:
                            {{ \Carbon\Carbon::parse($report['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</small></p>
                </div>
            </div>
        @endforeach
        
    </div>
    @endif

    <div class="divider-text">Service Request Progress</div>
    <h5 class="mt-4">Service Request Progress</h5>
    <div class="table-responsive mb-4">
        <table class="table table-hover mg-b-0" id="basicExample">
            <thead class="">
                <tr>
                    <th class="text-center">#</th>
                    <th>Author</th>
                    <th>Status</th>
                    <th class="text-center">Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($service_request['serviceRequestProgresses'] as $progress)
                    <tr>
                        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                         {{-- <td class="tx-medium">
                           {{ Str::title($progress['user']['account']['last_name'] . ' ' . $progress['user']['account']['first_name']) }} 
                            ({{ $progress['user']['roles'][0]['name'] }})</td> --}}
                            <td class="tx-medium">
                                {{ Str::title($progress['user']['account']['first_name'] . ' ' . $progress['user']['account']['last_name']) }}</td>
                        <td class="tx-medium text-success">
                            {{ $progress['substatus']['name'] }} </td>
                        <td class="text-center">
                            {{ Carbon\Carbon::parse($progress['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- table-responsive -->

    @if($service_request['toolRequest'])
     <div class="divider-text">Tools Request</div>
    <h5 class="mt-4">Tools Requests</h5>
    <div class="table-responsive mb-4">
        <table class="table table-hover mg-b-0">
            <thead class="">
                <tr>
                    <th class="text-center">#</th>
                    <th>Batch Number</th>
                    <th>Requested By</th>
                    <th>Approved By</th>
                    <th>Status</th>
                    <th>Date Requested</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>

                <tr>
                    <td class="tx-color-03 tx-center">1</td>
                    <td class="tx-medium">{{ $service_request['toolRequest']['unique_id'] }}</td>
                    <td class="tx-medium">{{ Str::title($service_request['toolRequest']['requester']['account']['first_name'] ." ". $service_request['toolRequest']['requester']['account']['last_name']) }}</td>
                    <td class="tx-medium">{{ !empty($service_request['toolRequest']['approver']) ? Str::title($service_request['toolRequest']['approver']['account']['first_name'] ." ". $service_request['toolRequest']['approver']['account']['last_name']) : 'UNAVIALABLE'}}</td>
                    <td class="text-medium {{ (($service_request['toolRequest']['status'] == 'Pending') ? 'text-warning' : (($service_request['toolRequest']['status'] == 'Approved') ? 'text-success' : 'text-danger')) }}">{{ $service_request['toolRequest']['status'] }}</td>

                    

                    <td class="text-medium">
                        {{ Carbon\Carbon::parse($service_request['toolRequest']['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                    </td>
                    <td class=" text-center">
                        <a href="#toolsRequestDetails" data-toggle="modal" class="btn btn-sm btn-primary" title="View {{ $service_request['toolRequest']['unique_id'] }} details" data-batch-number="{{ $service_request['toolRequest']['unique_id'] }}" data-url="{{ route('cse.tool_request_details', ['tool_request'=>$service_request['toolRequest']['uuid'], 'locale'=>app()->getLocale()]) }}" id="tool-request-details">Details</a>
                    </td>

                </tr>
            </tbody>
        </table>
    </div><!-- table-responsive -->
    @endif

    {{-- {{ dd($materials_accepted['rfqSupplierInvoice']['supplierInvoiceBatches']) }} --}}
    @if (!empty($materials_accepted))
    <div class="divider-text">Request For Quotation</div> 
    <h5 class="mt-4">Request For Quotation</h5>
    <div class="table-responsive mt-4">
        <h5>Supplier Details</h5>
        <table class="table table-striped table-sm mg-b-0">
            <tbody>
                <tr>
                    <td class="tx-medium">Supplier Name</td>
                    @if (!empty($materials_accepted['rfqSupplier']['supplier']['account']['first_name']))
                    <td class="tx-color-03">{{  Str::title($materials_accepted['rfqSupplier']['supplier']['account']['first_name'] ." ". $materials_accepted['rfqSupplier']['supplier']['account']['last_name']) }} <small class="text-muted">(Business Name: {{ collect($materials_accepted['rfqSupplier'])->isNotEmpty() ? $materials_accepted['rfqSupplier']['supplier']['supplier']['business_name'] : 'UNAVAILABLE'}})</small></td>
                    @else
                    <td class="tx-color-03"> UNAVAILABLE <small class="text-muted">(Business Name: UNAVAILABLE)</small></td>
                    @endif
                    
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Status</td>
                    @if($materials_accepted['status'] == 'Pending' || $materials_accepted['status'] == 'Awaiting')
                        <td class="text-warning">{{ $materials_accepted['status'] }}</td>
                    @elseif($materials_accepted['status'] == 'Shipped')
                        <td class="text-info">{{ $materials_accepted['status'] }}</td>
                    @elseif($materials_accepted['status'] == 'Delivered')
                        <td class="text-success">{{ $materials_accepted['status'] }}</td>
                    @endif
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Fee</td>
                    <td class="tx-color-03">₦{{ !empty($materials_accepted['rfqSupplier']['devlivery_fee']) ? number_format($materials_accepted['rfqSupplier']['devlivery_fee']) : 0 }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Time</td>
                    <td class="tx-color-03">{{ !empty($materials_accepted['rfqSupplier']['delivery_time']) ? Carbon\Carbon::parse($materials_accepted['rfqSupplier']['delivery_time'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') : 'UNAVAILABLE' }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Grand Total</td>
                    <td class="tx-color-03">₦{{ number_format($materials_accepted['total_amount'] ? $materials_accepted['total_amount'] : 0) }}</td>
                </tr>
            </tbody>
        </table>

        @if(!empty($materials_accepted['rfqSupplierInvoice']['supplierDispatch']))
        <h5 class="mt-4">Dispatch Details</h5>
        <table class="table table-striped table-sm mg-b-0">
            <tbody>

                <tr>
                    <td class="tx-medium">Courier Name</td>
                    <td class="tx-color-03">{{ !empty($materials_accepted['rfqSupplierInvoice']['supplierDispatch']['courier_name']) ? Str::title($materials_accepted['rfqSupplierInvoice']['supplierDispatch']['courier_name']) : 'UNAVAILABLE' }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Courier Phone Number</td>
                    <td class="tx-color-03">{{ !empty($materials_accepted['rfqSupplierInvoice']['supplierDispatch']['courier_phone_number']) ? $materials_accepted['rfqSupplierInvoice']['supplierDispatch']['courier_phone_number'] : 'UNAVAILABLE' }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Dispatch Code</td>
                    <td class="tx-color-03">{{ !empty($materials_accepted['rfqSupplierInvoice']['supplierDispatch']['unique_id']) ? $materials_accepted['rfqSupplierInvoice']['supplierDispatch']['unique_id'] : 'UNAVAILABLE' }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Dispatch Status</td>
                    @if($materials_accepted['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] == 'Processing')
                        <td class="text-warning">{{ $materials_accepted['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] }}</td>
                    @elseif($materials_accepted['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] == 'In-Transit')
                        <td class="text-info">{{ $materials_accepted['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] }}</td>
                    @elseif($materials_accepted['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] == 'Delivered')
                        <td class="text-success">{{ $materials_accepted['rfqSupplierInvoice']['supplierDispatch']['supplier_status'] }}</td>
                    @endif
                </tr>
                <tr>
                    <td class="tx-medium">Delivery Medium</td>
                    <td class="tx-color-03">{{ $materials_accepted['rfqSupplierInvoice']['supplierDispatch']['delivery_medium'] }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">Supplier Comment</td>
                    <td class="tx-color-03">{{ $materials_accepted['rfqSupplierInvoice']['supplierDispatch']['comment'] }}</td>
                </tr>
                <tr>
                    <td class="tx-medium">CSE Acceptance Comment</td>
                    <td class="tx-color-03">{{ $materials_accepted['rfqSupplierInvoice']['supplierDispatch']['cse_comment'] }}</td>
                </tr>

            </tbody>
        </table>
        @endif
    </div>

    <div class="table-responsive mt-4">
        <table class="table table-hover mg-b-0" id="basicExampl">
            <thead class="thead-primary">
                <tr>
                    <th class="text-center">#</th>
                    <th>Manufacturer Name</th>
                    <th>Model Number</th>
                    <th>Component Name</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">Size</th>
                    <th>Unit of Measurement</th>
                    <th class="text-center">Image</th>
                    <th class="text-center">Unit Price(₦)</th>
                    <th class="text-center">Amount(₦)</th>
                </tr>
            </thead>
            <tbody>
               
                @foreach ($materials_accepted['rfqBatches'] as $item)
                {{-- {{ dd($item['supplierInvoiceBatch']) }} --}}
                    <tr>
                        <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                        <td class="tx-medium">{{ !empty($item['manufacturer_name']) ? $item['manufacturer_name'] : 'UNAVAILABLE' }}</td>
                        <td class="tx-medium">{{ !empty($item['model_number']) ? $item['model_number'] : 'UNAVAILABLE' }}</td>
                        <td class="tx-medium">{{ !empty($item['component_name']) ? $item['component_name'] : 'UNAVAILABLE' }}</td>
                        <td class="tx-medium text-center">{{ !empty($item['quantity']) ? number_format($item->quantity) : '0' }}</td>
                        <td class="tx-medium text-center">{{ !empty($item['size']) ? number_format($item->size) : '0' }}</td>
                        <td class="tx-medium">{{ !empty($item['unit_of_measurement']) ? $item['unit_of_measurement'] : '-' }}</td>
                        <td class="text-center">
                            @if(!empty($item['image']))
                            <a href="#rfqImageDetails" data-toggle="modal" class="text-info" title="View {{ $item['component_name'] }} image" data-batch-number="{{ $item->id }}" data-url="{{ route('cse.rfq_details_image', ['image'=>$item->id, 'locale'=>app()->getLocale()]) }}" id="rfq-image-details"> View</a>
                            @else
                                -
                            @endif
                        </td>
                        <td class="tx-medium text-center">{{ !empty($item['supplierInvoiceBatch']['unit_price']) ? number_format($item['supplierInvoiceBatch']['unit_price']) : '0' }}</td>
                        <td class="tx-medium text-center">{{ !empty($item['supplierInvoiceBatch']['total_amount']) ? number_format($item['supplierInvoiceBatch']['total_amount']) : '0' }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div><!-- table-responsive -->
    @endif
</div>

@push('scripts')
    <script>
        $(function() {
            //Get image associated with invoice quote
            $(document).on('click', '#rfq-image-details', function(event) {
                event.preventDefault();
                let route = $(this).attr('data-url');
                let batchNumber = $(this).attr('data-batch-number');
                
                $.ajax({
                    url: route,
                    beforeSend: function() {
                    $("#modal-image-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                    },
                    // return the result
                    success: function(result) {
                        $('#modal-image-body').modal("show");
                        $('#modal-image-body').html('');
                        $('#modal-image-body').html(result).show();
                    },
                    complete: function() {
                        $("#spinner-icon").hide();
                    },
                    error: function(jqXHR, testStatus, error) {
                        var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
                        var type = 'error';
                        displayMessage(message, type);
                        $("#spinner-icon").hide();
                    },
                    timeout: 8000
                })
            });
        });
    </script>
@endpush

