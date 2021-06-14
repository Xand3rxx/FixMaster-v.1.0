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
                    <td class="tx-medium">{{ Str::title($service_request['toolRequest']['approver']['account']['first_name'] ." ". $service_request['toolRequest']['approver']['account']['last_name']) }}</td>
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
    {{-- <div class="divider-text">RFQ's</div>
    <h5 class="mt-4">Request For Quotation</h5>
    <div class="table-responsive">

        <table class="table table-hover mg-b-0 mt-4">
            <thead class="">
                <tr>
                    <th class="text-center">#</th>
                    <th>Batch Number</th>
                    <th>Client</th>
                    <th>Issued By</th>
                    <th>Status</th>
                    <th class="text-center">Total Amount</th>
                    <th>Date Created</th>
                    @if (Auth::user()->type->url != 'admin')
                        <th>Action</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php $y = 0; @endphp
                <tr>
                    <td class="tx-color-03 tx-center">{{ ++$y }}</td>
                    <td class="tx-medium">RFQ-C85BEA04 </td>
                    <td class="tx-medium">Kelvin Adesanya</td>
                    <td class="tx-medium">David Akinsola</td>
                    <td class="text-medium text-success">Payment received</td>
                    <td class="tx-medium text-center">₦{{ number_format(5000) ?? 'Null' }}
                    </td>
                    <td class="text-medium">
                        {{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                    </td>

                    <td class=" text-center">
                        <a href="#rfqDetails" data-toggle="modal" class="btn btn-sm btn-primary"
                            title="View RFQ-C85BEA04 details" data-batch-number="RFQ-C85BEA04"
                            data-url="#" id="rfq-details"></i> Details</a>
                    </td>

                </tr>
            </tbody>
        </table>
    </div><!-- table-responsive --> --}}
</div>

