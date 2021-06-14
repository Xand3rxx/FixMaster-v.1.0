@extends('layouts.client')
@section('title', 'Services')
@section('content')
@include('layouts.partials._messages')

<div class="col-lg-8 col-12">
    <h5 class="mt-4 mb-0">Book a Service</h5>

    <p class="text-muted mb-0 mt-4"><span class="text-dark">Keywords :</span> Electronics, Generator, Tiling, etc...</p>
    <p class=" mb-0 mt-4"><a href="{{ route('client.services.custom', app()->getLocale()) }}" class="text-primary">Can't find a Service that matches your need?</a></p>
    <form class="rounded p-4 mt-4 bg-white">
        <div class="row">
            <div class="col-lg-5 col-md-6">
                <div class="form-group mb-0">
                    <input type="text" class="form-control search-category" required="" placeholder="Keywords">
                </div>
            </div><!--end col-->
            
            <div class="col-lg-7 col-md-6">
                <div class="row align-items-center">
                    <div class="col-md-8 mt-4 mt-sm-0">
                        <div class="form-group mb-0">
                            <select class="form-control custom-select" id="sort-category">
                                <option selected value="">Select...</option>
                                    @foreach($categories as $category)
                                        @if($category->id != 1)
                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                        @endif
                                    @endforeach
                            </select>
                        </div>
                    </div><!--end col-->

                    
                </div><!--end row-->
            </div> <!---end col-->
        </div><!--end row-->
    </form>

    <div class="d-none search-result">
        <!-- Modal displays here -->
        <div id="spinner-icon"></div>
    </div>

    @foreach ($services as $service)
        <div class="services-list">
            <h5 class="mt-4 mb-0">{{ $service->name }}</h5>
            <div class="row">
                @foreach($service->services as $item)
                    <div class="col-md-4 mt-4 pt-2">
                        <div class="card blog rounded border-0 shadow">
                            <div class="position-relative">
                                @if(empty($item->image))
                                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top" height="100px !important">
                                @else
                                    @if(file_exists(public_path().'/assets/service-images/'.$item->image))
                                        <img src="{{ asset('assets/service-images/'.$item->image) }}" alt="{{ !empty($item->name) ? $item->name : 'UNAVAILABLE'  }}" class="card-img-top rounded-top">
                                    @else
                                        <img src="{{ asset('assets/images/no-image-available.png') }}" alt="Image not available" class="card-img-top rounded-top" height="100px !important">
                                    @endif
                                @endif

                                <div class="overlay rounded-top bg-dark"></div>
                            </div>
                            <div class="card-body content">
                                <h5><a href="javascript:void(0)" class="card-title title text-dark">{{ !empty($item->name) ? $item->name : 'UNAVAILABLE' }}</a> <a href="{{ route('client.services.details', ['service'=>$item->uuid, 'locale'=>app()->getLocale()]) }}" title="View {{ !empty($item->name) ? $item->name : 'UNAVAILABLE' }} service details"> <i data-feather="info" class="text-primary"></i></a></h5>
                                <div class="post-meta d-flex justify-content-between mt-3">
                                    <a href="{{ route('client.services.quote', ['service'=>$item->uuid, 'locale'=>app()->getLocale()]) }}" class="text-muted readmore">Request Service <i class="mdi mdi-chevron-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--end col-->
                @endforeach

            </div><!--end row-->
        </div>
    @endforeach
    
</div>
<input type="hidden" id="route" class="d-none" value="{{ route("client.services.search", app()->getLocale()) }}">

@push('scripts')
    <script src="{{ asset('assets/client/js/d5654a91-64a3-44ef-bb68-bee5c959e16c.js') }}"></script>
@endpush

@endsection