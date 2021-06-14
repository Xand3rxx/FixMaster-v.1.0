@extends('layouts.client')
@section('title', 'Requests')
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12">
    <h5 class="mb-0 mt-4">Service Request Overview</h5>
    <div class="table-responsive mt-4 bg-white rounded shadow">
        <div class="row mt-1 mb-1 ml-1 mr-1">
                <div class="col-md-4">
                    <div class="form-group position-relative">
                        <label>Sort Table</label>
                        <select class="form-control custom-select" id="request-sorting">
                            <option value="None">Select...</option>
                            <option value="Date">Date</option>
                            <option value="Month">Month</option>
                            <option value="Date Range">Date Range</option>
                        </select>
                    </div>
                </div><!--end col-->

                <div class="col-md-4 specific-date d-none">
                    <div class="form-group position-relative">
                        <label>Specify Date <span class="text-danger">*</span></label>
                        <i data-feather="calendar" class="fea icon-sm icons"></i>
                        <input name="name" id="name" type="date" class="form-control pl-5">
                    </div>
                </div>

                <div class="col-md-4 sort-by-year d-none">
                    <div class="form-group position-relative">
                        <label>Specify Year <span class="text-danger">*</span></label>
                        <select class="form-control custom-select" id="Sortbylist-Shop">
                            <option>Select...</option>
                            <option>2018</option>
                            <option>2019</option>
                            <option>2020</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-4 sort-by-year d-none">
                    <div class="form-group position-relative">
                        <label>Specify Month <span class="text-danger">*</span></label>
                        <select class="form-control custom-select" id="Sortbylist-Shop">
                            <option>Select...</option>
                            <option>January</option>
                            <option>February</option>
                            <option>March</option>
                            <option>April</option>
                            <option>May</option>
                            <option>June</option>
                            <option>July</option>
                            <option>August</option>
                            <option>September</option>
                            <option>October</option>
                            <option>November</option>
                            <option>December</option>
                        </select>
                    </div>
                </div>

                <div class="col-md-4 date-range d-none">
                    <div class="form-group position-relative">
                        <label>From <span class="text-danger">*</span></label>
                        <i data-feather="calendar" class="fea icon-sm icons"></i>
                        <input name="name" id="name" type="date" class="form-control pl-5">
                    </div>
                </div>

                <div class="col-md-4 date-range d-none">
                    <div class="form-group position-relative">
                        <label>To <span class="text-danger">*</span></label>
                        <i data-feather="calendar" class="fea icon-sm icons"></i>
                        <input name="name" id="name" type="date" class="form-control pl-5">
                    </div>
                </div>
        </div>

        <table class="table table-center table-padding mb-0" id="basicExample">
            <thead>
                <tr>
                    <th class="py-3">#</th>
                    <th class="py-3">Service Ref.</th>
                    <th class="py-3">CSE</th>
                    <th class="py-3">Scheduled Date</th>
                    <th class="py-3">Amount</th>
                    <th class="py-3">Fee Type</th>
                    <th class="py-3">Status</th>
                    <th class="py-3">Action</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($userServiceRequests as $userServiceRequest)
                {{-- {{ dd($userServiceRequest->serviceRequestDetail->timestamp) }} --}}
                    <tr>
                        <td class="text-center">{{ ++$i }}</td>
                        <td class="font-weight-bold">{{ $userServiceRequest->job_reference }}</td>
                        <td>@if(!empty($userServiceRequest->cse_id)) {{ $userServiceRequest->cse->first_name.' '.$userServiceRequest->cse->last_name }} @else Not Assigned @endif</td>
                        <td>{{ $userServiceRequest->serviceRequestDetail->timestamp ?? '' }}</td>
                        <td class="font-weight-bold text-center">
                            ₦{{ number_format($userServiceRequest->total_amount) }}
                            @if(!empty($userServiceRequest->serviceRequestDetail->discount_service_fee))
                                <sup style="font-size: 10px;" class="text-success">Discount</sup>
                            @endif
                        </td>
                        <td class="font-weight-bold">{{ $userServiceRequest->serviceRequestDetail->service_fee_name }}</td>
                        @if($userServiceRequest->serviceRequestStatus->name == 'Pending')
                            <td class="text-warning">Pending</td>
                        @elseif($userServiceRequest->service_request_status_id > '3')
                            <td class="text-info">Ongoing</td>
                        @elseif($userServiceRequest->serviceRequestStatus->name == 'Completed')
                            <td class="text-success">Completed</td>
                        @elseif($userServiceRequest->serviceRequestStatus->name == 'Cancelled')
                            <td class="text-danger">Cancelled</td>
                        @endif
                        
                        <td>
                            
                            <div class="btn-group dropdown-primary mr-2 mt-2">
                                <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Action
                                </button>
                                <div class="dropdown-menu">
                                    <a href="{{ route('client.request_details', $userServiceRequest->id) }}" class="dropdown-item text-primary"><i data-feather="clipboard" class="fea icon-sm"></i> View Details</a>
                                    @if($userServiceRequest->service_request_status_id == '1')
                                        <a href="#editRequest" id="edit-request" data-toggle="modal" class="dropdown-item text-info" data-url="{{ route('client.edit_request', $userServiceRequest->id) }}" data-job-reference="{{ $userServiceRequest->job_reference }}"><i data-feather="edit" class="fea icon-sm"></i> Edit Request</a>
                                    @endif
                                    
                                    @if($userServiceRequest->service_request_status_id != '3')
                                        <div class="dropdown-divider"></div>
                                        @if($userServiceRequest->service_request_status_id != '2')
                                            <a href="#cancelRequest" id="cancel-request" data-toggle="modal" data-url="{{ route('client.cancel_request', $userServiceRequest->id) }}" data-job-reference="{{ $userServiceRequest->job_reference }}" class="dropdown-item text-danger cancel_reques"><i data-feather="x" class="fea icon-sm"></i> Cancel Request</a>
                                        @else
                                            <a href="javascript:void(0)" class="dropdown-item text-success"><i data-feather="corner-up-left" class="fea icon-sm"></i> Reinstate Request</a>
                                        @endif
                                    @endif

                                    @if($userServiceRequest->service_request_status_id > '3')
                                        <a href="{{ route('client.mark_request_as_completed', $userServiceRequest->id) }}" class="dropdown-item details text-success"><i data-feather="check" class="fea icon-sm"></i> Mark as Completed</a>
                                    @endif

                                    @if($userServiceRequest->rfq()->where('status', '>', '0')->count() > 0)
                                    <hr>
                                        @foreach($userServiceRequest->rfqs as $rfq)
                                            <a href="{{ route('client.request_invoice', $rfq->id) }}" class="dropdown-item text-info"><i data-feather="file-text" class="fea icon-sm"></i> {{ $rfq->invoice_number }} Invoice</a>
                                        @endforeach
                                    @endif

                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
                
            </tbody>
        </table>
    </div>
</div><!--end col-->


<div class="modal fade" id="editRequest" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded shadow border-0">
        <div class="modal-header">
            {{-- <h5 class="modal-title" id="exampleModalCenterTitle">Modal title </h5> --}}
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal-edit-request">
            <!-- Modal displays here -->
            <div id="spinner-icon"></div>
        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

<div class="modal fade" id="cancelRequest" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded shadow border-0">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Kindly state your reason for cancellation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal-cancel-request">
            <form class="p-4" method="POST" id="cancel-request-form">
                @csrf
                <div class="row">
                    
                    <div class="col-md-12">
                        <div class="form-group position-relative">
                            <label>Reason</label>
                            <i data-feather="info" class="fea icon-sm icons"></i>
                            <textarea name="reason" id="reason" rows="3" class="form-control pl-5 @error('reason') is-invalid @enderror" placeholder="">{{ old('reason')  }}</textarea>
                            @error('reason')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div><!--end col--> 
            
                {{-- </div><!--end row--> --}}
            
                    <div class="col-sm-12">
                    <button type="submit" class="submitBnt btn btn-primary">Update</button>
                    </div><!--end col-->
                </div><!--end row-->
            </form><!--end form-->
        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->

@push('scripts')
<script>
    $(document).ready(function() {

        $(document).on('click', '#edit-request', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let jobReference = $(this).attr('data-job-reference');
        
            $.ajax({
                url: route,
                beforeSend: function() {
                    $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                // return the result
                success: function(result) {
                    $('#modal-edit-request').modal("show");
                    $('#modal-edit-request').html('');
                    $('#modal-edit-request').html(result).show();
                },
                complete: function() {
                    $("#spinner-icon").hide();
                },
                error: function(jqXHR, testStatus, error) {
                    var message = error+ ' An error occured while trying to retireve '+ jobReference +' service request details.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                },
                timeout: 8000
            })
        });

        $('.close').click(function (){
            $('#modal-edit-request').html('');
            $(".modal-backdrop").remove();
        });

        $(document).on('click', '#cancel-request', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let jobReference = $(this).attr('data-job-reference');

            $('#cancel-request-form').attr('action', route);
        });

        $(document).on('click', '.cancel_request', function(){
            Swal.fire({
                title: 'Are you sure you want to cancel your request?',
                // text: "You won't be able to revert this!",
                // icon: 'question',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, cancel it!',
                imageUrl: '{{ asset("assets/images/home-fix-logo.png") }}',
                imageWidth: 100,
                imageHeight: 'auto',
                imageAlt: 'FixMaster Logo'

            }).then((result) => {
                
                if (result.value) {
            (async () => {
                const { value: text } = await Swal.fire({
                    input: 'textarea',
                    inputLabel: 'Why do you want to cancel your request?',
                    inputPlaceholder: 'Type your reason here...',
                    inputAttributes: {
                        'aria-label': 'Type your reason here'
                    },
                    showCancelButton: true
                    })

                    if (text) {
                        // Swal.fire(text)
                        Swal.fire(
                            'Cancelled!',
                            'Your request has been cancelled.',
                            'success'
                        )
                    }else{
                        Swal.fire(
                            'Cancelled!',
                            'You need to state a reason.',
                            'error'
                        )
                    }
                })()
                } 
            });
        });

        $('#request-sorting').on('change', function (){        
                let option = $("#request-sorting").find("option:selected").val();

                if(option === 'None'){
                    $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Date'){
                    $('.specific-date').removeClass('d-none');
                    $('.sort-by-year, .date-range').addClass('d-none');
                }

                if(option === 'Month'){
                    $('.sort-by-year').removeClass('d-none');
                    $('.specific-date, .date-range').addClass('d-none');
                }

                if(option === 'Date Range'){
                    $('.date-range').removeClass('d-none');
                    $('.specific-date, .sort-by-year').addClass('d-none');
                }
        });
    });
   
</script>
@endpush

@endsection