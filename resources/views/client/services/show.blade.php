@extends('layouts.client')
@section('title', 'Service Details')
@section('content')
@include('layouts.partials._messages')

<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/font-awesome/3.2.1/css/font-awesome.css">
<link href="{{ asset('assets/frontend/css/service-details.css') }}" rel="stylesheet" type="text/css"/>

{{-- {{ dd($service->serviceRequests()->count()) }} --}}
<div class="col-lg-8 col-12" style="margin-top: 3rem;">

    <div class="row mt-4">
        <div class="col-md-5">
            <div class="card blog rounded border-0 shadow">
                <div class="position-relative">
                    @if(empty($service->image))
                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top">
                    @else
                        @if(file_exists(public_path().'/assets/service-images/'.$service->image))
                            <img src="{{ asset('assets/service-images/'.$service->image) }}" alt="{{ $service->name }}" class="card-img-top rounded-top">
                        @else
                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top">
                        @endif
                    @endif
                <div class="overlay rounded-top bg-dark"></div>
                </div>

                <div class="author">
                <h4 class="text-light user d-block"><i class="mdi mdi-account"></i> {{ $service->name }}</h4>
                    <small class="text-light date"><i class="mdi mdi-bookmark"></i> {{ $service->serviceRequests()->count() }} Requests</small>
                </div>
            </div>
            <div class="mt-4 pt-2">
                <a href="{{ route('client.services.quote', ['service'=>$service->uuid, 'locale'=>app()->getLocale()]) }}" class="btn btn-primary">Request Service</a>
            </div>
        </div><!--end col-->

        <div class="col-md-7 mt-4 mt-sm-0 pt-2 pt-sm-0">
            <div class=" ml-md-4">
                <div class="row">
                    <div class="star-main-rating">
                        <div class="inner_game">
                            <div class="rating_game mt-3 text-center">
                                <span class="rating-num">{{round($rating->avg('star'))}}</span>
                                <div class="rating-stars">
                                    <ul class="list-unstyled mb-0">
                                        @if(round($rating->avg('star'))==1)
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        @elseif(round($rating->avg('star'))==2)
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        @elseif(round($rating->avg('star'))==3)
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        @elseif(round($rating->avg('star'))==4)
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        @elseif(round($rating->avg('star'))==5)
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                        @else
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        @endif
                                    </ul>
                                </div>
                                <div class="rating-users text-center"> {{$rating->count()}} total</div>
                            </div>
                        </div>
                    </div>


                <div class="star-width rating-bars">
                    <div class="rating-holder">
                        <ul>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">5</span> --}}
                                    <span class="rating-star-holder text-warning">★★★★★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 100%;" class="bar-position green"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;898</div>
                                </div> --}}
                            </li>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">4</span> --}}
                                    <span class="rating-star-holder text-warning">★★★★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 75%;" class="bar-position green"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;309</div>
                                </div> --}}
                            </li>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">3</span> --}}
                                    <span class="rating-star-holder text-warning">★★★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 50%;" class="bar-position green"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;283</div>
                                </div> --}}
                            </li>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">2</span> --}}
                                    <span class="rating-star-holder text-warning">★★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 35%;" class="bar-position red"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;125</div>
                                </div> --}}
                            </li>
                            <li class="">
                                <div class="rating-category">
                                    {{-- <span class="rating-digit-holder">1</span> --}}
                                    <span class="rating-star-holder text-warning">★</span>
                                </div>
                                <div class="col rating-bars ml-5">
                                    <div class="rating-bar-bg"><span style="width: 20%;" class="bar-position red"></span></div>
                                </div>
                                {{-- <div class="">
                                    <div class="rating-total-numbers">&nbsp;273</div>
                                </div> --}}
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

                <br>
                <h5 class="mt-4 py-2">Description :</h5>
                <p class="text-muted">{{ $service->description }}</p>

            </div>
        </div><!--end col-->
    </div><!--end row-->

    <div class="row mt-4">
        <div id="customer-testi" class="owl-carousel owl-theme">
            @foreach ($rating as $rate)
              @foreach($reviews as $review)
             <div class="media customer-testi m-2">
                    <img src="{{ asset('assets/user-avatars/'.$review->clientAccount->avatar) }}" class="avatar avatar-small mr-3 rounded shadow" alt="">
                    <div class="media-body content p-3 shadow rounded bg-white position-relative">
                        <div class="rating-stars">
                        <ul class="list-unstyled mb-0">

                            @if($rate->rater_id === $review->client_id && $rate->service_id === $review->service_id)

                                             @if($rate->star == 1)
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-grey"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            @elseif($rate->star == 2)
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            @elseif($rate->star == 3)
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            @elseif($rate->star == 4)
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            @elseif($rate->star == 5)
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-warning"></i></li>
                                            @else
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                            <li class="list-inline-item"><i class="mdi mdi-star text-gray"></i></li>
                                        @endif

                                        @endif

                        </ul>
                        <p class="text-muted mt-2">{{$review->reviews}}</p>
                        <h6 class="text-primary">- {{$review->clientAccount->first_name}} {{$review->clientAccount->last_name}}<small class="text-muted"> </small></h6>
                    </div>
             </div>
                </div>
             @endforeach
             @endforeach
        </div>
    </div>
</div>



@section('scripts')
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script> --}}

<script>
    $(document).ready(function() {
        $('.bar span').hide();
        $('#bar-five').animate({
            width: '90%'}, 1000);
        $('#bar-four').animate({
            width: '75%'}, 1000);
        $('#bar-three').animate({
            width: '50%'}, 1000);
        $('#bar-two').animate({
            width: '30%'}, 1000);
        $('#bar-one').animate({
            width: '19%'}, 1000);

        setTimeout(function() {
            $('.bar span').fadeIn('slow');
        }, 1000);

    });

</script>
@endsection

@endsection
