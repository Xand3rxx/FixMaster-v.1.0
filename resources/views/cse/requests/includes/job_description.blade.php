<div id="description" class="tab-pane pd-20 pd-xl-25">
    <div class="divider-text">Service Request Description</div>

    <h6>SERVICE REQUEST DESCRIPTION</h6>
    <div class="row row-xs mt-4">
        <div class="col-lg-12 col-xl-12">
            <table class="table table-striped table-sm mg-b-0">
                <tbody>
                    <tr>
                        <td class="tx-medium">Job Reference</td>
                        <td class="tx-color-03"> {{ $service_request['unique_id'] }}</td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Service Required</td>
                        <td class="tx-color-03"> {{ $service_request['service']['name'] }}</td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Scheduled Date & Time </td>
                        <td class="tx-color-03">
                            {{ !empty($service_request['preferred_time']) ? Carbon\Carbon::parse($service_request->preferred_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') : 'Not Scheduled yet' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Payment Status </td>
                        <td class="tx-color-03"><span
                                class="text-success">{{ ucfirst($service_request->payment_statuses->status) }}</span>({{ ucfirst($service_request->payment_statuses->payment_channel) }})
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Booking Fee</td>
                        <td class="tx-color-03">
                            ₦{{ number_format($service_request['price']['amount']) }} ({{ $service_request['price']['name'] }}
                            Price)</td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Security Code</td>
                        <td class="tx-color-03">{{ $service_request['client_security_code'] }}
                        </td>
                    </tr>

                    <tr>
                        <td class="tx-medium">CSE's Assigned</td>
                        <td class="tx-color-03">
                            {{ CustomHelpers::arrayToList($service_request->service_request_assignees, 'cse-user') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Technicians Assigned</td>
                        <td class="tx-color-03">
                            {{ CustomHelpers::arrayToList($service_request->service_request_assignees, 'technician-artisans') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Quality Assurance Managers Assigned</td>
                        <td class="tx-color-03">
                            {{ CustomHelpers::arrayToList($service_request->service_request_assignees, 'quality-assurance-user') }}
                        </td>

                    </tr>
                    <tr>
                        <td class="tx-medium">State</td>
                        <td class="tx-color-03">
                            {{ $service_request['client']['account']['state']['name'] ?? 'UNAVAILABLE' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">L.G.A</td>
                        <td class="tx-color-03">
                            {{ $service_request['client']['account']['lga']['name'] ?? 'UNAVAILABLE' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Town/City</td>
                        <td class="tx-color-03">
                            {{ $service_request['client']['account']['town']['name'] ?? 'UNAVAIALABLE' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Request Address</td>
                        <td class="tx-color-03">
                            {{ $service_request['client']['account']['contact'] == null ? '' : $service_request['client']['account']['contact']['address'] }}.
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Request Description</td>
                        <td class="tx-color-03">{{ $service_request['description'] }}.</td>
                    </tr>

                    @if (!empty($service_request['service_request_cancellation']))
                        <tr>
                            <td class="tx-medium">Reason for Cancellation </td>
                            <td class="tx-color-03">{{ $service_request['service_request_cancellation']['reason'] }}<br>
                                <small class="text-danger">Date Cancelled: {{ Carbon\Carbon::parse($service_request['service_request_cancellation']['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</small>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>

            <div class="divider-text">Media Files</div>
            @if (count($service_request['serviceRequestMedias']) > 0)
            <div class="row row-xs">
                @foreach ($service_request['serviceRequestMedias'] as $item)
                    @include('cse.requests.includes._media_file')
                @endforeach
            </div>
            @else
            <h5 class="mt-4">Files have not been uploaded for this request.</h5>
            @endif
        </div><!-- df-example -->
    </div>
</div>
