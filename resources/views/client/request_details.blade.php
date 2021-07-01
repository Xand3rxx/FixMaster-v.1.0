@extends('layouts.client') 
@section('title', 'Request Details') 
@section('content')
@include('layouts.partials._messages')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/lightgallery.css') }}" />

<style>.h6 {font-weight: 400 !important;}</style>

<div class="col-lg-8 pt-4 col-12">
    <div class="float-right pt-4 mb-4">
        <a href="{{ route('client.service.all', app()->getLocale()) }}" class="btn btn-sm btn-primary">Back </a>
        @if($requestDetail->status_id == '1')

        @if(collect($requestDetail['service_request_assignees'])->count() < 2)
            <a href="{{ route('client.edit_request', [ 'request'=>$requestDetail->uuid, 'locale'=>app()->getLocale() ])}}" class="btn btn-sm btn-warning">Edit Request </a>
        @endif
        <a href="#cancelRequest" id="cancel-request" data-toggle="modal" data-url="{{ route('client.cancel_request', [ 'request'=>$requestDetail->uuid, 'locale'=>app()->getLocale() ]) }}" data-job-reference="{{ $requestDetail->unique_id  }}" class="btn btn-sm btn-danger">Cancel Request </a>
        @elseif($requestDetail->status_id == '4')
        <a href="#" id="activate"
        data-url="{{ route('client.reinstate_request', [ 'request'=>$requestDetail->uuid, 'locale'=>app()->getLocale() ]) }}" 
        class="btn btn-sm btn-warning" title="Reinstate">Reinstate Request </a>
        @endif
    </div>

    <div class="ml-lg-4 mt-4">
        <div class="pb-4 row col-md-12">
            <div class="col-md-6">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Eslint.svg') }}" class="avatar avatar-ex-sm" alt="" />
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Service</h4>
                        <p class="text-muted mb-0">{{ $requestDetail['service']['name'] ?? 'Custom Request' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Gradle.svg') }}" class="avatar avatar-ex-sm" alt="" />
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Category</h4>
                      
                        <p class="text-muted mb-0">{{ $requestDetail['service']['category']['name'] ?? 'Custom Request'}}</p>
                    </div>
                </div>
            </div>
        </div>

        @if(collect($requestDetail['service_request_assignees'])->isNotEmpty())
            @foreach($requestDetail['service_request_assignees'] as $item)
                @if($item->user->roles[0]->slug == 'cse-user' && $item->status == 'Active')
                    <h5 class="mt-4">CSE Assigned</h5>
                    <div class="col-lg-12 col-12 mt-4">
                        <div class="card rounded bg-light overflow-hidden border-0 m-2">
                            <div class="row align-items-center no-gutters">
                                <div class="col-md-5">
                                    @if(!empty($item['user']['account']['avatar']) &&
                                    file_exists(public_path().'/assets/user-avatars/'.$item['user']['account']['avatar']))
                                        <img src="{{ asset('assets/user-avatars/'.$item['user']['account']['avatar']) }}" class="img-fluid" alt="" />
                                    @elseif($item['user']['account']['gender'] == 'male' || $item['user']['account']['gender'] == 'others')
                                        <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="img-fluid" />
                                    @else
                                        <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="img-fluid" />
                                    @endif
                                </div>
                                <!--end col-->

                                <div class="col-md-7">
                                    <div class="card-body">
                                        <h6 class="text-primary font-weight-bold">{{ $item['user']['account']['first_name'].' '.$item['user']['account']['last_name'] }} <small class="text-muted d-block">{{ $requestDetail->roles[0]->name ?? 'Customer Service Executive' }} | FixMaster</small></h6>
                                        <ul class="list-unstyled mb-0">
                                            @for ($i = 0; $i < round($item['user']['ratings']->avg('star')); $i++)
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            @endfor
                                            @for ($x = 0; $x < (5 - round($item['user']['ratings']->avg('star'))); $x++)
                                                <li class="list-inline-item"><i class="mdi mdi-star text-muted"></i></li>
                                            @endfor
                                        </ul>
                                        <p class="h6 mb-0">Security Code</p>
                                        <p class="text-muted mb-0 font-weight-bold">{{ $requestDetail->client_security_code }}</p>
                                        <div class="mt-4">
                                            {{-- <a href="{{ route('client.technician_profile',app()->getLocale()) }}" class="btn btn-sm btn-outline-primary">View Profile</a> --}}
                                            <a href="#validateSecurityCode" data-toggle="modal" class="btn btn-sm btn-outline-primary">CSE & Technician Profiles</a>

                                            {{-- @if($requestDetail->status_id != '3')
                                                <a href="#" data-toggle="modal" data-target="#message-modal" class="btn btn-sm btn-primary">Send Message </a>
                                            @endif
                                        </div> --}}
                                    </div>
                                </div>
                                <!--end col-->
                            </div>
                            <!--end row-->
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
       
        <h5 class="mt-4">Job Reference </h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>{{ $requestDetail['unique_id'] }}</li>
        </ul>

        <h5 class="mt-4">Location & Scheduled Time</h5>
        <p style="font-size: 11px;" class="text-danger">Location and appointment time as specified by you.</p>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="map-pin" class="fea icon-sm text-primary mr-2"></i>{{ $requestDetail['address']['address'] }}</li>
            <li class="text-muted mt-2"><i data-feather="calendar" class="fea icon-sm text-primary mr-2"></i>{{ Carbon\Carbon::parse($requestDetail->preferred_time, 'UTC')->isoFormat('dddd Do YYYY') }}</li>
        </ul>


        <h5 class="mt-4">Service Charge ({{ $requestDetail['price']['name'] }}):</h5>
        <ul class="list-unstyled">
        @if(!empty($requestDetail->clientDiscounts[0]->discount->rate) && ($requestDetail->clientDiscounts[0]->availability == 'unused'))

            <li class="text-muted">
                <i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>
               <del> ₦{{ number_format($requestDetail['price']['amount']) }} </del> &nbsp;
                ₦{{ number_format(CustomHelpers::discountCalculation($requestDetail->clientDiscounts[0]->discount->rate,$requestDetail->price->amount )) }}
                <sup style="font-size: 10px;" class="text-success">Discount</sup>
            </li>
            @else
            <li class="text-muted">
                <i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>
               ₦{{ number_format($requestDetail['price']['amount']) }} 
            </li>
            @endif
        </ul>

        <h5 class="mt-4">Status</h5>
        <ul class="list-unstyled">
            @if($requestDetail->status_id == '1')
            <li class="text-warning"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Pending</li>
            @elseif($requestDetail->status_id == '2')
            <li class="text-info"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Ongoing</li>
            @elseif($requestDetail->status_id == '4')
            <li class="text-success"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Completed</li>
            @elseif($requestDetail->status_id == '3')
            <li class="text-danger"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Cancelled</li>
            @endif
        </ul>

        <h5 class="mt-4">Payment Status</h5>
        <ul class="list-unstyled">
            <li class="{{ (($requestDetail['payment']['status'] == 'pending') ? 'text-warning' : (($requestDetail['payment']['status'] == 'success') ? 'text-success' : ($requestDetail['payment']['status'] == 'failed' ? 'text-danger' : 'text-danger'))) }}"><i data-feather="arrow-right" class="fea icon-sm mr-2"></i> {{ !empty($requestDetail['payment']['status']) ? ucfirst($requestDetail['payment']['status']) : 'UNAVAILABLE' }}</li>
        </ul>


        <h5 class="mt-4">Payment Method</h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm  mr-2"></i> {{ !empty($requestDetail['payment']['payment_channel']) ? ucfirst($requestDetail['payment']['payment_channel']) : 'UNAVAILABLE' }}</li>
        </ul>

        <h5>Request Description</h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i> {{ $requestDetail->description ?? 'UNAVAILABLE' }}</li>
        </ul>

        @if(!empty($requestDetail->service_request_cancellation->reason))
        <h5>Cancellation Reason</h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i> {{ $requestDetail->service_request_cancellation->reason }}</li>
        </ul>
        @endif

        <h5>Uploaded Media Files</h5>
        @if (count($requestDetail['serviceRequestMedias']) > 0)
        <div class="row row-xs">
            @foreach ($requestDetail['serviceRequestMedias'] as $item)
                @include('client._media_file')
            @endforeach
        </div>
        @else
        <h6 class="mt-4">Files have not been uploaded for this request.</h6>
        @endif
    </div>
</div>
<!--end col-->

<div class="modal fade" id="validateSecurityCode" tabindex="-1" role="dialog" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title">Validate CSE & Technician</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <input type="hidden" class="d-none" id="security-code" readonly value="{{ $requestDetail->client_security_code  }}" />
                <div class="col-md-12">
                    <div class="form-group position-relative">
                        <label>Security Code:<span class="text-danger">*</span></label>
                        <i data-feather="lock" class="fea icon-sm icons"></i>
                        <input name="security_code" type="text" class="form-control pl-5" placeholder="Security Code:" id="security_code" value="" required />
                        <small style="font-size: 11px;" class="text-danger">Security code must be in uppercase.<small>
                    </div>
                </div>
                <!--end col-->
                <div class="col-md-2">
                    <button type="button" class="btn btn-primary verify-security-code">Verify</button>
                </div>
            </div>
        </div>
        <!-- modal-body -->
    </div>
    <!-- modal-content -->
</div>
<!-- modal-dialog -->

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
            <form class="p-4" method="GET" id="cancel-request-form">
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

@if(collect($requestDetail['service_request_assignees'])->isNotEmpty())
<div class="modal fade" id="cseTechnicianModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">CSE & Technician Profiles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-12 mt-4 pt-2 text-center">
                        <ul class="nav nav-pills nav-justified flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                            @foreach ($requestDetail['service_request_assignees'] as $assignee)
                            @if($assignee['user']['roles'][0]['slug'] != 'admin-user')

                                <li class="nav-item">
                                    <a class="nav-link rounded @if($assignee['user']['roles'][0]['slug'] == "cse-user") active @endif" id="{{ $assignee['user']['roles'][0]['slug'] }}-tab" data-toggle="pill" href="#{{ $assignee['user']['roles'][0]['slug'] }}" role="tab" aria-controls="{{ $assignee['user']['roles'][0]['slug'] }}" aria-selected="false">
                                        <div class="text-center pt-1 pb-1">
                                            <h4 class="title font-weight-normal mb-0">
                                                {{ $assignee['user']['roles'][0]['name'] }}
                                            </h4>
                                        </div>
                                    </a>
                                </li>
                                @endif
                            @endforeach
                            
                        </ul>
                        <!--end nav pills-->
                    </div>
                </div>

                <div class="tab-content" id="pills-tabContent">

                    @foreach($requestDetail->service_request_assignees as $assignee)
                    @if($assignee['user']['roles'][0]['slug'] != 'admin-user')

                        <div class="tab-pane fade show @if($assignee['user']['roles'][0]['slug'] == "cse-user") active @endif" id="{{ $assignee['user']['roles'][0]['slug'] }}" role="tabpanel" aria-labelledby="{{ $assignee['user']['roles'][0]['slug']}}-tab">
                        <div class="col-lg-12 col-12 mt-4">
                            <div class="card rounded bg-light overflow-hidden border-0 m-2">
                                <div class="row align-items-center no-gutters">
                                    <div class="col-md-5">
                                    
                                        @if(!empty($assignee['user']['account']['avatar']) && file_exists(public_path().'/assets/user-avatars/'.$assignee['user']['account']['avatar']))
                                            <img src="{{ asset('assets/user-avatars/'.$assignee['user']['account']['avatar']) }}" class="img-fluid" alt="" />
                                        @elseif($assignee['user']['account']['gender'] == 'male')
                                            <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="img-fluid" />
                                        @else
                                            <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="img-fluid" />
                                        @endif
                                    </div>

                                    <div class="col-md-7">
                                        <div class="card-body">
                                            <h6 class="text-primary font-weight-bold">{{ $assignee['user']['account']['first_name'].' '.$assignee['user']['account']['last_name'] }} <small class="text-muted d-block">{{ $assignee['user']['roles'][0]['name'] }} | FixMaster</small></h6>
                                            <ul class="list-unstyled mb-0">
                                                @for ($i = 0; $i < round($assignee['user']['ratings']->avg('star')); $i++)
                                                    <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                @endfor
                                                @for ($x = 0; $x < (5 - round($assignee['user']['ratings']->avg('star'))); $x++)
                                                    <li class="list-inline-item"><i class="mdi mdi-star text-muted"></i></li>
                                                @endfor
                                            </ul>

                                            <ul class="list-unstyled">
                                                {{-- <li class="h6 text-muted">Completed Jobs :</span> {{ $requestDetail->service_request_assignee['user']->userCompletedJobs()->where('status_id',
                                                    4)->count() }}
                                                </li> --}}

                                                <li class="h6 text-muted">Address : {{ !empty($assignee['user']['contact']) ? $assignee['user']['contact']['address'] : 'UNAVAILABLE' }}</li>

                                                <li class="h6 text-muted">Mobile : {{ !empty($assignee['user']['contact']) ? $assignee['user']['contact']['phone_number'] : 'UNAVAILABLE' }}</li> 
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endif


@push('scripts')
    <script src="{{ asset('assets/client/js/requests/4c676ab8-78c9-4a00-8466-a10220785892.js') }}"></script> 
    <script src="{{ asset('assets/dashboard/assets/js/lightgallery-all.min.js') }}"></script>

    <script>
    $(function(){
        //Initiate light gallery plugin
        $('.lightgallery').lightGallery();
    });
    </script>
@endpush

@endsection
