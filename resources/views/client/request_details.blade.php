@extends('layouts.client') 
@section('title', 'Request Details') 
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12">
    <div class="float-right mt-4">
        <a href="{{ route('client.service.all', app()->getLocale()) }}" class="btn btn-sm btn-primary">Back </a>
        @if($requestDetail->status_id == '1')
        <a href="#editRequest" id="edit-request" data-toggle="modal" data-url="{{ route('client.edit_request', [ 'request'=>$requestDetail->uuid, 'locale'=>app()->getLocale() ])}}" data-job-reference="{{ $requestDetail->unique_id  }}" class="btn btn-sm btn-warning">Edit Request </a>

        <a href="#cancelRequest" id="cancel-request" data-toggle="modal" data-url="{{ route('client.cancel_request', [ 'request'=>$requestDetail->uuid, 'locale'=>app()->getLocale() ]) }}" data-job-reference="{{ $requestDetail->unique_id  }}" class="btn btn-sm btn-danger">Cancel Request </a>
        @elseif($requestDetail->status_id == '3')
        <a href="#" id="activate"
        data-url="{{ route('client.reinstate_request', [ 'request'=>$requestDetail->uuid, 'locale'=>app()->getLocale() ]) }}" 
        class="btn btn-sm btn-warning" title="Reinstate">Reinstate Request </a>
        @endif
    </div>

    <div class="ml-lg-4">
        <h5 class="mt-4">Service Request: {{ $requestDetail->unique_id  }}</h5>

        <div class="border-bottom pb-4 row">
            <div class="col-md-6">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Eslint.svg') }}" class="avatar avatar-ex-sm" alt="" />
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Service</h4>
                        <p class="text-muted mb-0">{{ $requestDetail->service->name ?? 'Custom Request' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                    <img src="{{ asset('assets/images/job/Gradle.svg') }}" class="avatar avatar-ex-sm" alt="" />
                    <div class="media-body content ml-3">
                        <h4 class="title mb-0">Category</h4>
                      
                        <p class="text-muted mb-0">{{ $requestDetail->service->category->name ?? 'Custom Request'}}</p>
                    </div>
                </div>
            </div>
        </div>

       
        @if(!empty($requestExists->service_request_assignees))
        @foreach($requestExists->service_request_assignees as $item)
          @if($item->user->roles[0]->url == 'cse' && $item->status == 'Active')
        <h5 class="mt-4">CSE Assigned</h5>
        <div class="col-lg-12 col-12 mt-4">
            <div class="card rounded bg-light overflow-hidden border-0 m-2">
                <div class="row align-items-center no-gutters">
                    <div class="col-md-5">
                         @if(!empty($item->user->account->avatar) &&
                        file_exists(public_path().'/assets/user-avatars/'.$item->user->account->avatar))
                            <img src="{{ asset('assets/user-avatars/'.$item->user->account->avatar) }}" class="img-fluid" alt="" />
                        @elseif($item->user->account->gender == 'male')
                            <img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="img-fluid" />
                        @else
                            <img src="{{ asset('assets/images/default-female-avatar.png') }}" alt="Default female profile avatar" class="img-fluid" />
                        @endif
                    </div>
                    <!--end col-->

                    <div class="col-md-7">
                        <div class="card-body">
                            <h6 class="text-primary font-weight-bold">{{ $item->user->account->first_name.' '.$item->user->account->avatar->last_name }} <small class="text-muted d-block">{{ $requestDetail->cses[0]->roles[0]->name ?? 'Customer Service Executive' }} | FixMaster</small></h6>
                            <ul class="list-unstyled mb-0">
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
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
       

        <h5 class="mt-4">Location & Scheduled Time</h5>
        <p style="font-size: 10px;" class="text-muted">Location and appointemnt time as specified by you.</p>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="map-pin" class="fea icon-sm text-primary mr-2"></i>{{ $requestDetail->address->address }}</li>
            <li class="text-muted"><i data-feather="calendar" class="fea icon-sm text-primary mr-2"></i>{{ Carbon\Carbon::parse($requestDetail->preferred_time, 'UTC')->isoFormat('dddd Do YYYY, h:mm:ssa') }}</li>
        </ul>


        <h5 class="mt-4">Service Charge ({{ $requestDetail['price']['name'] }}):</h5>
        <ul class="list-unstyled">
        @if(!empty($requestDetail->clientDiscounts[0]->discount->rate) && ($requestDetail->clientDiscounts[0]->availability == 'unused'))

            <li class="text-muted">
                <i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>
               <del> ₦{{ number_format($requestDetail->total_amount) }} </del> &nbsp;
                ₦{{ number_format(CustomHelpers::discountCalculation($requestDetail->clientDiscounts[0]->discount->rate,$requestDetail->price->amount )) }}
                <sup style="font-size: 10px;" class="text-success">Discount</sup>
            </li>
            @else
            <li class="text-muted">
                <i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>
               ₦{{ number_format($requestDetail->total_amount) }} 
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

        <h5 class="mt-4">Payment Method</h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Payment Method: {{ !empty($requestDetail->payment_statuses->payment_channel) ? ucfirst($requestDetail->payment_statuses->payment_channel) : 'UNAVAILABLE' }}</li>
            {{--
            <li class="text-muted">
                <i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i>Payment Gateway: PayStack
                <img src="{{ asset('assets/images/payments/payment/master-card.jpg') }}" class="img-fluid avatar avatar-small mx-2 rounded-circle shadow" />
            </li>
            --}}
        </ul>

        <h5>Request Description</h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i> {{ $requestDetail->description }}</li>
        </ul>

        @if(!empty($requestDetail->service_request_cancellation->reason))
        <h5>Cancellation Reason</h5>
        <ul class="list-unstyled">
            <li class="text-muted"><i data-feather="arrow-right" class="fea icon-sm text-primary mr-2"></i> {{ $requestDetail->service_request_cancellation->reason }}</li>
        </ul>
        @endif
    </div>
</div>
<!--end col-->

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
                        <small style="font-size: 10px;" class="text-danger">Security code must be in uppercase.<small>
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


@if($requestDetail->service_request_assignees->count() > 0)
<div class="modal fade" id="cseTechnicianModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded shadow border-0">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle">CSE & Technician Profiles</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                {{-- CSE Profile --}}

                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-12 mt-4 pt-2 text-center">
                        <ul class="nav nav-pills nav-justified flex-column flex-sm-row rounded" id="pills-tab" role="tablist">
                            @foreach ($requestDetail->service_request_assignees as $assignee)
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
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                                <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            </ul>

                                            <ul class="list-unstyled">
                                                {{-- <li class="h6">
                                                    <i data-feather="activity" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Completed Jobs :</span> {{ $requestDetail->service_request_assignee['user']->userCompletedJobs()->where('status_id',
                                                    4)->count() }}
                                                </li> --}}
                                                <li class="h6"><i data-feather="map-pin" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">State :</span> {{ !empty($assignee['user']['account']['state_id']) ? $assignee['user']['account']->state->name : 'UNAVAILABLE' }}</li>


                                                <li class="h6"><i data-feather="map-pin" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">L.G.A:</span> {{ !empty($assignee['user']['account']['lga_id']) ? $assignee['user']['account']->lga->name : 'UNAVAILABLE' }}</li> 

                                                <li class="h6"><i data-feather="map-pin" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Town/Ward:</span> {{ !empty($assignee['user']['account']['town_id']) ? $assignee['user']['account']->town->name : 'UNAVAILABLE' }}</li> 

                                                <li class="h6"><i data-feather="home" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Address :</span> {{ $assignee['user']->contact == null ? '': $assignee['user']->contact->address }}</li>

                                                <li class="h6"><i data-feather="phone" class="fea icon-sm text-warning mr-2"></i><span class="text-muted">Mobile :</span> {{ $assignee['user']->contact == null ? '' : $assignee['user']->contact->phone_number }}</li> 
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

@section('scripts')

@push('scripts')
<script src="{{ asset('assets/client/js/requests/4c676ab8-78c9-4a00-8466-a10220785892.js') }}"></script> 
@endpush
@endsection
@endsection
