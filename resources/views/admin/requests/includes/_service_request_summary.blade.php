<div id="serviceRequestSummary" class="tab-pane pd-20 pd-xl-25">
    @if(count($serviceRequest['serviceRequestReports']) > 0)
    <div class="divider-text"> Reports/Comments</div>
    <div class="card-grou">
        @foreach ($serviceRequest['serviceRequestReports'] as $report)
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

  

    @if($serviceRequest['toolRequest'])
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
                    <td class="tx-medium">{{ $serviceRequest['toolRequest']['unique_id'] }}</td>
                    <td class="tx-medium">{{ Str::title($serviceRequest['toolRequest']['requester']['account']['first_name'] ." ". $serviceRequest['toolRequest']['requester']['account']['last_name']) }}</td>
                    <td class="tx-medium">{{ Str::title($serviceRequest['toolRequest']['approver']['account']['first_name'] ." ". $serviceRequest['toolRequest']['approver']['account']['last_name']) }}</td>
                    <td class="text-medium {{ (($serviceRequest['toolRequest']['status'] == 'Pending') ? 'text-warning' : (($serviceRequest['toolRequest']['status'] == 'Approved') ? 'text-success' : 'text-danger')) }}">{{ $serviceRequest['toolRequest']['status'] }}</td>

                    

                    <td class="text-medium">
                        {{ Carbon\Carbon::parse($serviceRequest['toolRequest']['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}
                    </td>
                    <td class=" text-center">
                        <a href="#toolsRequestDetails" data-toggle="modal" class="btn btn-sm btn-primary" title="View {{ $serviceRequest['toolRequest']['unique_id'] }} details" data-batch-number="{{ $serviceRequest['toolRequest']['unique_id'] }}" data-url="{{ route('cse.tool_request_details', ['tool_request'=>$serviceRequest['toolRequest']['uuid'], 'locale'=>app()->getLocale()]) }}" id="tool-request-details">Details</a>
                    </td>

                </tr>
            </tbody>
        </table>
    </div><!-- table-responsive -->
    @endif
    
    @if((collect($serviceRequest['serviceRequestReports'])->isEmpty()) && (collect($serviceRequest['toolRequest'])->isEmpty()))
        <h5 class="mt-4">No records for this job request.</h5>
    @endif
</div>

