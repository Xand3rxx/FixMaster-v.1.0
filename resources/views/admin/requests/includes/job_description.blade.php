<div id="description" class="tab-pane pd-20 pd-xl-25 show active">
    <div class="divider-text">Service Request Description</div>

    <h6>SERVICE REQUEST DESCRIPTION</h6>
    <div class="row row-xs mt-4">
        <div class="col-lg-12 col-xl-12">
            <table class="table table-striped table-sm mg-b-0">
                <tbody>
                    <tr>
                        <td class="tx-medium">Job Reference</td>
                        <td class="tx-color-03"> {{ $serviceRequest['unique_id'] }}</td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Service Required</td>
                        <td class="tx-color-03"> {{ $serviceRequest['service']['name'] }}</td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Scheduled Date </td>
                        <td class="tx-color-03">
                            {{ !empty($serviceRequest['preferred_time']) ? Carbon\Carbon::parse($serviceRequest->preferred_time, 'UTC')->isoFormat('MMMM Do YYYY') : 'Not Scheduled yet' }}
                        </td>
                    </tr>

                    <tr>
                        <td class="tx-medium">Payment Status </td>
                        <td class="tx-color-03"><span
                                class="{{ (($serviceRequest['payment_statuses']['status'] == 'pending') ? 'text-warning' : (($serviceRequest['payment_statuses']['status'] == 'success') ? 'text-success' : (($serviceRequest['payment_statuses']['status'] == 'failed') ? 'text-danger' : 'text-danger'))) }}">{{ ucfirst($serviceRequest->payment_statuses->status) }}</span>({{ ucfirst($serviceRequest->payment_statuses->payment_channel) }})
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Booking Fee</td>
                        <td class="tx-color-03">
                            ₦{{ number_format($serviceRequest['price']['amount']) }} ({{ $serviceRequest['price']['name'] }}
                            Price)</td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Security Code</td>
                        <td class="tx-color-03">{{ $serviceRequest['client_security_code'] }}
                        </td>
                    </tr>

                    <tr>
                        <td class="tx-medium">CSE's Assigned</td>
                        <td class="tx-color-03">
                            {{ CustomHelpers::arrayToList($serviceRequest->service_request_assignees, 'cse-user') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Technicians Assigned</td>
                        <td class="tx-color-03">
                            {{ CustomHelpers::arrayToList($serviceRequest->service_request_assignees, 'technician-artisans') }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Quality Assurance Managers Assigned</td>
                        <td class="tx-color-03">
                            {{ CustomHelpers::arrayToList($serviceRequest->service_request_assignees, 'quality-assurance-user') }}
                        </td>

                    </tr>
                    <tr>
                        <td class="tx-medium">State</td>
                        <td class="tx-color-03">
                            {{ $serviceRequest['client']['account']['state']['name'] ?? 'UNAVAILABLE' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">L.G.A</td>
                        <td class="tx-color-03">
                            {{ $serviceRequest['client']['account']['lga']['name'] ?? 'UNAVAILABLE' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Town/City</td>
                        <td class="tx-color-03">
                            {{ $serviceRequest['client']['account']['town']['name'] ?? 'UNAVAIALABLE' }}
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Request Address</td>
                        <td class="tx-color-03">
                            {{ $serviceRequest['client']['account']['contact'] == null ? '' : $serviceRequest['client']['account']['contact']['address'] }}.
                        </td>
                    </tr>
                    <tr>
                        <td class="tx-medium">Request Description</td>
                        <td class="tx-color-03">{{ $serviceRequest['description'] }}.</td>
                    </tr>

                    @if (!empty($serviceRequest['service_request_cancellation']))
                        <tr>
                            <td class="tx-medium">Reason for Cancellation </td>
                            <td class="tx-color-03">{{ $serviceRequest['service_request_cancellation']['reason'] }}<br>
                                <small class="text-danger">Date Cancelled: {{ Carbon\Carbon::parse($serviceRequest['service_request_cancellation']['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</small>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
            <div class="divider-text">Media Files</div>
            @if (count($serviceRequest['serviceRequestMedias']) > 0)
            <div class="row row-xs">
                @foreach ($serviceRequest['serviceRequestMedias'] as $item)
                    @include('admin.requests.includes._media_file')
                @endforeach
            </div>
            @else
            <h5 class="mt-4">Files have not been uploaded for this request.</h5>
            @endif
        </div><!-- df-example -->
    </div>
</div>


@push('scripts')
    <script>
        $(document).ready(function(){
            //Initiate light gallery plugin
            $('.lightgallery').lightGallery();

            $(document).on('click', '#contact-me', function(){
                var contactMe = parseInt($(this).attr('data-contact-me'));

                if(contactMe == 0){
                    displayMessage('Sorry! The client does not want to be contacted.', 'error');
                    return;
                }
            });

            $('.notify-client-schedule-date').on('click', function(e) {
                // Trigger Ajax call to send notification
                $.ajax({
                    url: "{{ route('cse.notify.client', app()->getLocale()) }}",
                    method: "POST",
                    dataType: "JSON",
                    data: {
                        "_token": "{{ csrf_token() }}",
                        "service_request": $(this).data('service')
                    },
                    success: function(data) {
                        console.log(data);
                        displayMessage(data, 'success');
                    },
                    catch: function(error) {
                        displayMessage(error.data, 'error');
                    }
                });
                // User service requuest client_id
                // return respose of either success or failed
            });
        });
    </script>
@endpush
