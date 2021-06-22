@extends('layouts.client')
@section('title', 'Custom Service Quote')
@section('content')
@include('layouts.partials._messages')
@include('client.services.includes._service_quote_css')

<div class="col-lg-8 col-12">
    <div class="card custom-form border-0">
        <div class="card-body mt-4">
            <div class="row">
                <div class="col-lg-12 col-md-12 mt-4 pt-2">
                    <div class="media key-feature align-items-center p-3 rounded shadow text-primary">
                        <div class="icon text-center rounded-circle mr-3">
                            <i data-feather="git-merge" class="fea icon-ex-md text-primary"></i>
                        </div>
                        <div class="media-body">
                            <h4 class="title mb-0">Custom Service Quote</h4>
                        </div>
                    </div>
                </div><!--end col-->
            </div>

            <form class="rounded p-4" action="{{ route('client.service-request.store', app()->getLocale()) }}" method="POST" id="payment" enctype="multipart/form-data">
                @csrf
                <small class="text-danger text-small">A Booking Fee deposit is required to validate this order and enable our AI assign a Customer Service Executice(CSE) to your Job.</small>

                <div class="row" id="pills-tab" role="tablist">
                    @include('client.services.includes._hidden_fields')

                    <ul class="nav nav-pills bg-white nav-justified flex-column mb-0" id="pills-tab" role="tablist">
                        @foreach($bookingFees as $bookingFee)
                        <li class="nav-item bg-light rounded-md mt-4">
                            <a class="nav-link rounded-md @if(old('price_id') == $bookingFee->id) active @endif" id="dashboard-{{$bookingFee->id}}" data-toggle="pill" href="#dash-board-{{$bookingFee->id}}" role="tab" aria-controls="dash-board-{{$bookingFee->id}}" aria-selected="false">

                                <div class="p-3 text-left">
                                    <h5 class="title">{{ !empty($bookingFee->name) ? $bookingFee->name : 'UNAVAILABLE' }}: ₦{{ number_format(!empty($bookingFee->amount) ? $bookingFee->amount : '0') }}</h5>
                                    <p class="text-muted tab-para mb-0 text-small-2">{{ !empty($bookingFee->description) ? $bookingFee->description : 'No description found' }}</p>
                                    <input type="radio" name="price_id" value="{{ old('price_id') ?? $bookingFee->id }}" class="custom-control-input booking-fee" />
                                    <input type="radio" name="booking_fee" value="{{ old('booking_fee') ?? $bookingFee->amount }}" class="custom-control-input booking-fee-2" />
                                </div>
                            </a>
                            <!--end nav link-->
                        </li>
                        <!--end nav item-->
                        @endforeach
                    </ul>
                    <!--end nav pills-->
                </div>

                <!-- Client frequently used service reauest contacts-->
                <div class="row">
                    <div class="col-lg-12 col-md-12 mt-4" id="address">
                        <div class="contact-list">
                            @include('client.services._contactList')
                        </div>                        
                    </div>
                </div>

                <div class="d-flex align-items-center justify-content-between mt-4 col-lg-12">  
                    <button type="button" name="add" id="add_new_contact" data-toggle="modal" data-target="#add_data_Modal" class="btn btn-primary btn-sm"><i data-feather="plus" class="fea icon-sm"></i> Add New Contact</button>  
                </div> 

                <div class="display-request-body">
                    @include('client.services.includes._service_quote_description_body')
                </div>
            </form>

        </div>
    </div>
</div>

@include('client.services._newAddress')

@push('scripts')
    <script src="{{ asset('assets/js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/client/js/requests/378334e4-df3a-4060-a856-aaf8d7c4ce6b.js') }}"></script>
@endpush 

@endsection




