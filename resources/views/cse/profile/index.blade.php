@extends('layouts.dashboard')
@section('title', 'Profile')
@include('layouts.partials._messages')
@section('content')

<div class="content-body pd-0">
    <div class="contact-wrapper contact-wrapper-two">
        <div class="contact-content">
            <div class="contact-content-header">
                <nav class="nav">
                </nav>
            </div><!-- contact-content-header -->

            <div class="contact-content-body">
                <div class="tab-content">

                    <div id="contactInformation" class="tab-pane show active pd-20 pd-xl-25">
                        <div class="d-flex align-items-center justify-content-between mg-b-25">
                            <h5 class="mg-b-0">Personal Details</h5>
                            <div class="d-flex">
                                <a href="{{ route('cse.profile.edit',[app()->getLocale()]) }}" class="btn btn-sm btn-white d-flex align-items-center mg-r-5"><i data-feather="edit-2"></i><span class="d-none d-sm-inline mg-l-5"> Edit</span></a>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-6 col-sm">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Firstname</label>
                                <p class="mg-b-0">{{ $user['account']['first_name'] }}</p>
                            </div><!-- col -->
                            <div class="col-6 col-sm">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Middlename</label>
                                <p class="mg-b-0">{{ $user['account']['middle_name'] }}</p>
                            </div><!-- col -->
                            <div class="col-sm mg-t-20 mg-sm-t-0">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Lastname</label>
                                <p class="mg-b-0">{{ $user['account']['last_name'] }}</p>
                            </div><!-- col -->
                        </div><!-- row -->

                        <h5 class="mg-t-40 mg-b-20">Contact Details</h5>

                        <div class="row row-sm">
                            <div class="col-6 col-sm-4">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Email Address</label>
                                <p class="tx-primary mg-b-0">{{ $user['email'] }}</p>
                            </div>
                            <div class="col-6 col-sm-4">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Mobile Phone</label>
                                <p class="tx-primary tx-rubik mg-b-0">{{ $user['contact']['phone_number'] }}</p>
                            </div>
                            <div class="col-6 col-sm-4">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">CSE ID</label>
                                <p class="tx-primary tx-rubik mg-b-0">{{$user['cse']['unique_id']}}</p>
                            </div>
                            <div class="col-6 col-sm-4 mg-t-20 mg-sm-t-30">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Referral Code</label>
                                <p class="tx-primary tx-rubik mg-b-0">{{$user['cse']['referral']['referral_code']}}</p>
                            </div>
                            <div class="col-6 col-sm-4 mg-t-20 mg-sm-t-30">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Franchisee</label>
                                <p class="mg-b-0">{{$user['cse']['franchisee']['name']}}</p>
                            </div>

                            <div class="col-sm-6 mg-t-20 mg-sm-t-30">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Address</label>
                                <p class="mg-b-0">{{ $user['contact']['address'] }}</p>
                            </div>

                            <div class="col-sm-6 mg-t-20 mg-sm-t-30">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Rating</label>
                                <p class="mg-b-0">
                                    <div class="pd-t-10 pd-b-15 d-flex align-items-baseline">
                                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5">{{round(Auth::user()->ratings->avg('star'))}}</h1>
                                        <div class="tx-18">
                                            @if(round(Auth::user()->ratings->avg('star')) == 1)
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            @elseif(round(Auth::user()->ratings->avg('star')) == 2)
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            @elseif(round(Auth::user()->ratings->avg('star')) == 3)
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            @elseif(round(Auth::user()->ratings->avg('star')) == 4)
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            @elseif(round(Auth::user()->ratings->avg('star')) == 5)
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            @else
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                            @endif
                                        </div>
                                    </div>
                                </p>
                            </div>

                        </div><!-- row -->

                        <h5 class="mg-b-20">Bank Details</h5>
                        <div class="row row-sm">
                            <div class="col-6 col-sm-6">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Bank</label>
                                <p class="tx-rubik mg-b-0">{{ $user['account']['bank']['name'] }}</p>
                            </div>
                            <div class="col-sm-6">
                                <label class="tx-10 tx-medium tx-spacing-1 tx-color-03 tx-uppercase tx-sans mg-b-10">Account Number</label>
                                <p class="tx-primary mg-b-0">{{ $user['account']['account_number'] }}</p>
                            </div>
                        </div><!-- row -->
                    </div>
                </div><!-- tab-content -->
            </div><!-- contact-content-body -->

        </div><!-- contact-content -->

    </div><!-- contact-wrapper -->
</div>

@endsection
