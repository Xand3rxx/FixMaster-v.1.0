@extends('layouts.client')
@section('title', 'Home')
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12">
    <div class="border-bottom pb-4 row">
        {{-- <h5>Femi Joseph</h5>
        <p class="text-muted mb-0">I have started my career as a trainee and prove my self and achieve all the milestone with good guidance and reach up to the project manager. In this journey, I understand all the procedure which make me a good developer, team leader, and a project manager.</p>--}}
        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Total Requests</h4>
                    <p class="text-muted mb-0">{{ $totalRequests }} </p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>

        </div>

        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Completed Requests</h4>
                <p class="text-muted mb-0">{{ $completedRequests }}</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>
        </div>

        <div class="col-md-4 mt-4">
            <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                <img src="{{ asset('assets/images/job/Circleci.svg') }}" class="avatar avatar-ex-sm" alt="">
                <div class="media-body content ml-3">
                    <h4 class="title mb-0">Pending Requests</h4>
                <p class="text-muted mb-0">{{ $cancelledRequests }}</p>
                    {{-- <p class="text-muted mb-0"><a href="javascript:void(0)" class="text-primary">CircleCi</a> @London, UK</p>     --}}
                </div>
            </div>
        </div>
    </div> 
    
    <div class="border-bottom pb-4">
        <div class="row">
            <div class="col-md-6 mt-4">
                <h5>Personal Details :</h5>
                <div class="mt-4">
                    <div class="media align-items-center">
                        <i data-feather="mail" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Email :</h6>
                        <a href="javascript:void(0)" class="text-muted">{{ $user->user->email }}</a>
                        </div>
                    </div>
                    <div class="media align-items-center mt-3">
                        <i data-feather="phone" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Phone No :</h6>
                        <a href="javascript:void(0)" class="text-muted">{{ $client['phone_number'] }}</a>
                        </div>
                    </div>
                    <div class="media align-items-center mt-3">
                        <i data-feather="bookmark" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Occupation :</h6>
                        <a href="javascript:void(0)" class="text-muted">{{ $user->profession->name ?? 'Not Selected' }}</a>
                        </div>
                    </div>
                    <div class="media align-items-center mt-3">
                        <i data-feather="map" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">State :</h6>
                        <p class="text-muted mb-0">{{ $user->state->name ?? 'UNAVAILABLE' }}</p>
                        </div>
                    </div>


                    <div class="media align-items-center mt-3">
                        <i data-feather="map-pin" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">L.G.A :</h6>
                        <p class="text-muted mb-0">{{ $user->lga->name ?? "UNAVAILABLE" }}</p>
                        </div>
                    </div>

                    <div class="media align-items-center mt-3">
                        <i data-feather="map-pin" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Town/City :</h6>
                        <p class="text-muted mb-0">{{ $user->town->name ?? "UNAVAILABLE" }}</p>
                        </div>
                    </div>
                    <div class="media align-items-center mt-3">
                        <i data-feather="map" class="fea icon-ex-md text-muted mr-3"></i>
                        <div class="media-body">
                            <h6 class="text-primary mb-0">Full Address :</h6>
                        <a href="javascript:void(0)" class="text-muted">{{ $client['address'] }}</a>
                        </div>
                    </div>
                </div>
            </div><!--end col-->

            <div class="col-md-6 mt-4 pt-2 pt-sm-0">
                <h5>Recent Requests :</h5>
              
                @php $count = 0; @endphp
                @if($userServiceRequests['service_requests']->isNotEmpty())
                    @foreach ($userServiceRequests['service_requests'] as $userServiceRequest)
                    @if($count++ < 3)
                        <div class="media key-feature align-items-center p-3 rounded shadow mt-4">
                            <img src="{{ asset('assets/images/job/Webhooks.svg')}}" class="avatar avatar-ex-sm" alt="">
                            <div class="media-body content ml-3">
                                <h4 class="title mb-0">{{ $userServiceRequest['service']['name'] }}({{ $userServiceRequest['service']['category']['name'] ?? 'Custom Request'}})</h4>
                            
                                @if(!empty($userServiceRequest->clientDiscounts[0]->discount->rate) && ($userServiceRequest->clientDiscounts[0]->availability == 'unused') )
                                <p class="text-muted mb-0"><span>Amount:</span> 
                                <del>₦ {{ $userServiceRequest->price->amount}}</del>
                                </p>
                                <p class="text-muted mb-0"><span>Discount:</span> 
                                        ₦{{ number_format(CustomHelpers::discountCalculation($userServiceRequest->clientDiscounts[0]->discount->rate,$userServiceRequest->price->amount )) }}
                                        <sup style="font-size: 10px;" class="text-success">Discount</sup>
                                        </p>
                                    @else

                                        <p class="text-muted mb-0"><span>Amount:</span> 
                                ₦ {{ $userServiceRequest['price']['amount']}}
                                </p>
                                @endif 
                            
                                <p class="mb-0"><a href="{{ route('client.request_details', [ 'request'=>$userServiceRequest['uuid'], 'locale'=>app()->getLocale() ]) }}" style="color: #161c2d" title="View Service request details">CSE: <span class="text-muted">

                                    @if($userServiceRequest['service_request_assignees']->count() > 0)
                                        @foreach ($userServiceRequest['service_request_assignees'] as $item)
                                            @if(($item['user']['roles'][0]['slug'] == 'cse-user') && ($item['status'] == 'Active'))
                                                {{ $item['user']['account']['first_name'].' '.$item['user']['account']['last_name'] }}
                                                @php break; @endphp
                                            @else
                                                Not Assigned
                                            @endif
                                        @endforeach
                                    @else
                                        Not Assigned 
                                    @endif
                                </span></a></p> 
                                <p class="mb-0">Status: 
                                    @if($userServiceRequest->status_id == '1')
                                        <span class="text-warning">Pending</span>
                                    @elseif($userServiceRequest->status_id == '2')
                                        <span class="text-info">Ongoing</span>
                                    @elseif($userServiceRequest->status_id == '4')
                                        <span class="text-success">Completed</span>
                                    @elseif($userServiceRequest->status_id == '3')
                                        <span class="text-danger">Cancelled</span>
                                    @endif
                                </p>  
                            </div>
                        </div>
                    @endif  
                    @endforeach 
                @else
                You have not booked a Service!<br>
                    <a href="{{ route('client.services.list', app()->getLocale()) }}" class="btn btn-primary mouse-down">Book a  Service</a>
                @endif
            </div><!--end col-->
        </div><!--end row-->
    </div>

    <h5 class="mt-4 mb-0">Popular Requests :</h5>
    <div class="row">
        
        @foreach ($popularRequests as $popularRequest)
        <div class="col-md-4 mt-4 pt-2">
            <div class="card blog rounded border-0 shadow">
                <div class="position-relative">
                    @if(empty($popularRequest->image))
                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top">
                    @else
                        @if(file_exists(public_path().'/assets/service-images/'.$popularRequest->image))
                            <img src="{{ asset('assets/service-images/'.$popularRequest->image) }}" alt="{{ $popularRequest->name }}" class="card-img-top rounded-top">
                        @else
                            <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top">
                        @endif
                    @endif
                <div class="overlay rounded-top bg-dark"></div>
                </div>
                <div class="card-body content">
                <h5><a href="javascript:void(0)" class="card-title title text-dark">{{ !empty($popularRequest->name) ? $popularRequest->name : 'UNAVAILABLE' }}</a> <a href="#" title="View {{ $popularRequest->name }} service details"> <i data-feather="info" class="text-primary"></i></a></h5>
                    <div class="post-meta d-flex justify-content-between mt-3">
                        <a href="{{ route('client.services.quote', ['service'=>$popularRequest->uuid, 'locale'=>app()->getLocale()]) }}" class="text-muted readmore">Request Service <i class="mdi mdi-chevron-right"></i></a>
                    </div>
                </div>
                <div class="author">
                <small class="text-light date"><i class="mdi mdi-calendar"></i> Requests: 12</small><br>
                <small class="text-light date"><i class="mdi mdi-credit-card"></i> Basic Price: ₦{{ number_format(3500) }}</small>

                </div>
            </div>
        </div><!--end col-->
        @endforeach
        
    </div><!--end row-->
</div><!--end col-->
<div>
<input type="hidden"  data-url="{{ route('client.discount_mail',app()->getLocale()) }}" id="get_url" />
<input type="hidden"  data-token="{{ csrf_token() }}" class="get_token" /> 
<input type="hidden"  data-users="{{ Auth::user()->id }}" id="get_users" /> 
<input type="hidden"  data-name="{{ Auth::user()->account->first_name }}" id="get_name" /> 
    </div>


@push('scripts')
@if(Session::has('verified'))
<script src="{{asset('assets/dashboard/assets/js/verified.js')}}"></script>
@endif
@endpush


@endsection


