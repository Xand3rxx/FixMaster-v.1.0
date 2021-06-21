@extends('layouts.client')
@section('title', 'My Service Requests')
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12" style="margin-top: 3rem;">

<div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <h4 class="mg-b-0 tx-spacing--1">My Service Request as of {{ date('M, d Y') }}</h4>
                </div>

            </div>

            <div class="row row-xs mt-4">
                <div class="col-lg-12 col-xl-12 mg-t-10">
                    <div class="card mg-b-10">
                        <div class="table-responsive">

                            <table class="table table-hover mg-b-0" id="basicExample">
                                <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Job Reference</th>
                                    <th>Service Name</th>
                                    <th class="text-center">Service Charge(₦)</th>
                                    <th>Status</th>
                                    <th>Scheduled Date</th>
                                    <th>Date Created </th>
                                    <th class="text-center">Action</th>
                                </tr>
                                </thead>
                                <tbody>


                            @if($myServiceRequests['service_requests']->isNotEmpty())
                                @foreach ($myServiceRequests['service_requests'] as $myServiceRequest)  
                                <tr>

                                <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                <td class="font-weight-bold">{{ $myServiceRequest->unique_id }} </td>
                                <td>{{ $myServiceRequest['service']['name'] ?? 'Custom Request' }} </td>
                                <td class="text-center font-weight-bold">{{ $myServiceRequest->bookingFee->amount }}</td>
                                <td class="tx-medium">
                                @if($myServiceRequest->status_id == 1)
                                    <span class="badge badge-warning rounded">Pending</span>
                                @elseif($myServiceRequest->status_id == 2)
                                    <span class="badge badge-info rounded">Ongoing</span>
                                @elseif($myServiceRequest->status_id == 3)
                                    <span class="badge badge-danger rounded">Cancelled</span>
                                @elseif($myServiceRequest->status_id == 4)
                                    <span class="badge badge-success rounded">Completed</span>
                                @endif
                                </td>
                                <td class="tx-medium font-weight-bold">{{ !empty($myServiceRequest['preferred_time']) ? Carbon\Carbon::parse($myServiceRequest['preferred_time'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') : 'Not Scheduled yet'}} </td>
                                <td class="tx-medium">{{ Carbon\Carbon::parse($myServiceRequest['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                                <td class=" text-center">

                                    <div class="btn-group dropdown-primary mr-2 mt-2">
                                        <button type="button" class="btn btn-primary btn-sm dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            Action
                                        </button>
                                        <div class="dropdown-menu">
                                             <a href="{{ route('client.request_details', [ 'request'=>$myServiceRequest->uuid, 'locale'=>app()->getLocale() ]) }}" class="dropdown-item text-primary"><i data-feather="clipboard" class="fea icon-sm"></i> Details</a>

                                             @if($myServiceRequest->status_id == 2)

                                             <a href="#" id="completed"
                                             data-url="{{ route('client.completed_request', [ 'request'=>$myServiceRequest->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-success" title="Mark as completed">
                                                    <i data-feather="check" class="fea icon-sm"></i> Mark as Completed</a>
                                             @endif

                                             <!-- @if($myServiceRequest->status_id == 1)
                                             <a href="#editRequest" id="edit-request"
                                             data-toggle="modal"
                                             data-url="{{ route('client.edit_request', [ 'request'=>$myServiceRequest->uuid, 'locale'=>app()->getLocale() ])}}"
                                              data-job-reference="{{ $myServiceRequest->unique_id  }}" class="dropdown-item details text-warning">
                                               <i data-feather="edit" class="fea icon-sm"></i> Edit Request </a>

                                             @endif -->

                                             @if($myServiceRequest->status_id < 3)
                                               @if( $myServiceRequest->service_request_assignees->count() > 1 )
                                             <a href="{{ route('client.edit_request', [ 'request'=>$myServiceRequest->uuid, 'locale'=>app()->getLocale() ]) }}" class="dropdown-item text-primary"><i data-feather="edit" class="fea icon-sm"></i> Edit Request</a>
                                               @endif
                                             @endif

                                             @if($myServiceRequest->status_id == 1)
                                                <div class="dropdown-divider"></div>
                                                <a href="#cancelRequest" id="cancel-request" data-toggle="modal"
                                                data-url="{{ route('client.cancel_request', [ 'request'=>$myServiceRequest->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                data-job-reference="{{ $myServiceRequest->unique_id  }}"
                                                class="dropdown-item text-danger"><i data-feather="x" class="fea icon-sm"></i> Cancel Request </a>
                                            @endif
                                            @if($myServiceRequest->status_id == 3)
                                                <div class="dropdown-divider"></div>
                                             <a href="#" id="activate"
                                             data-url="{{ route('client.reinstate_request', [ 'request'=>$myServiceRequest->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                    class="dropdown-item details text-success" title="Reinstate">
                                                    <i data-feather="corner-up-left" class="fea icon-sm"></i> Reinstate Request</a>
                                            @endif

                                            @foreach($myServiceRequest['invoices']->where('service_request_id', $myServiceRequest->id)->whereIn('phase', ['1', '2']) as $invoice)
                                                <a href="{{ route('invoice', ['locale' => app()->getLocale(), 'invoice' => $invoice['uuid']]) }}" class="dropdown-item details text-info"><i data-feather="file-text" class="fea icon-sm"></i> {{ $invoice['invoice_type'] }}</a>
                                            @endforeach


                                            @if($myServiceRequest->status_id == 4 && !empty($myServiceRequest['warranty']))

                                            @if($myServiceRequest['warranty']['expiration_date'] >  Carbon\Carbon::now())
                                                <div class="dropdown-divider"></div>

                                                @if($myServiceRequest['warranty']['initiated'] != 'Yes')

                                                <a href="#warrantyInitiate" id="warranty-initiate"
                                                data-toggle="modal"
                                                data-url="{{ route('client.warranty_initiate', [ 'request'=> $myServiceRequest->uuid, 'locale'=>app()->getLocale() ]) }}"
                                                 data-job-reference="{{ $myServiceRequest->unique_id  }}" class="dropdown-item text-success"><i data-feather="award" class="fea icon-sm"></i> Pending Warranty</a>

                                                 @endif
                                            @endif
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                </tr>

                                <!-- <div class="modal fade" id="LoginForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"> -->
                {{-- <div class="modal fade" id="view{{$myServiceRequest->service->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalCenterTitle">Service Request Details </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>

                    <div class="modal-body">

                        <div class="form-row mt-4">
                            <div class="form-group col-md-12">
                            <div class="form-group col-md-12">
                                    <label for="percentage">Description </label>
                                    <!-- <input type="text" class="form-control" value="{{$myServiceRequest->service->description }}" autocomplete="off"> -->
                                    <textarea rows="3" class="form-control" >{{$myServiceRequest->service->description }}</textarea>
                                </div>

                                <div class="form-group col-md-12">
                                    <label for="percentage">Service Request Address</label>
                                    <input type="text" class="form-control" value="{{$myServiceRequest->service->client_security_code }}" autocomplete="off">

                                </div>

                                <div class="form-group col-md-12">
                                    <label for="percentage">Assigned To</label>
                                    <input type="text" class="form-control" value="{{$myServiceRequest->service->client_security_code }}" autocomplete="off">

                                </div>


                            </div>
                            <!-- <button type="submit" class="btn btn-primary">Create Tax</button> -->
                        </div>

                    </div><!-- modal-body -->

                    <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div><!-- modal-footer -->

    </div><!-- modal-content --> --}}
  </div><!-- modal-dialog -->
</div><!-- modal -->


                                @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div><!-- table-responsive -->
                    </div><!-- card -->

                </div><!-- col -->
            </div><!-- row -->

        </div><!-- container -->
    </div>


<!-- @section('scripts')
    <script>


    </script>
@endsection -->

</div>

<div class="modal fade" id="cancelRequest" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded shadow border-0">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Kindly state your reason for cancellation </h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal-cancel-request">
            <form class="p-4" method="GET" id="cancel-request-form">
                @csrf
                <div class="row">
                <input type="hidden" value="{{ !empty($myServiceRequest) ? $myServiceRequest->bookingFee->amount : 0}}" name="amountToRefund"/>
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
                    <button type="submit" class="submitBnt btn btn-primary">Submit</button>
                    </div><!--end col-->
                </div><!--end row-->
            </form><!--end form-->
        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->
</div><!-- modal -->


<div class="modal fade" id="warrantyInitiate" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
      <div class="modal-content rounded shadow border-0">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalCenterTitle">Kindly state your reason for Initiating Warranty</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="modal-cancel-request">
            <form class="p-4" method="GET" id="warranty-initiate-form">
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
                    <button type="submit" class="submitBnt btn btn-primary">Initiate</button>
                    </div><!--end col-->
                </div><!--end row-->
            </form><!--end form-->
        </div>
        </div><!-- modal-body -->
      </div><!-- modal-content -->
    </div><!-- modal-dialog -->

</div><!-- modal -->



<div class="modal fade" id="editRequest" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                {{--
                <h5 class="modal-title" id="exampleModalCenterTitle">Modal title</h5>
                --}}
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="modal-edit-request">
                <!-- Modal displays here -->
                <div id="spinner-icon"></div>
            </div>
        </div>
        <!-- modal-body -->
    </div>
    <!-- modal-content -->
</div>
<!-- modal-dialog -->



@push('scripts')

<script src="{{ asset('assets/client/js/requests/4c676ab8-78c9-4a00-8466-a10220785892.js') }}"></script>
@endpush
@endsection
