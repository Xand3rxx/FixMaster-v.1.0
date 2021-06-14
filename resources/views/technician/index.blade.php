@extends('layouts.dashboard')
@section('title', Auth::user()->type->role->name.' Dashboard' ?? 'Technician Dashboard')
@include('layouts.partials._messages')
@section('content')

    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item active">Dashboard</li>
                            {{-- <li class="breadcrumb-item active" aria-current="page">Website Analytics</li> --}}
                        </ol>
                    </nav>
                    <h4 class="mg-b-0 tx-spacing--1">Welcome to Fix<span style="color: #E97D1F;">Master</span> {{ Auth::user()->type->role->name ?? 'Technician' }} Dashboard</h4>
                    {{-- <h4 class="mg-b-0 tx-spacing--1">Welcome  Dashboard</h4> --}}
                </div>
                {{-- <div class="d-none d-md-block">
                  <button class="btn btn-sm pd-x-15 btn-white btn-uppercase"><i data-feather="save" class="wd-10 mg-r-5"></i> Save</button>
                  <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="upload" class="wd-10 mg-r-5"></i> Export</button>
                  <button class="btn btn-sm pd-x-15 btn-white btn-uppercase mg-l-5"><i data-feather="share-2" class="wd-10 mg-r-5"></i> Share</button>
                  <button class="btn btn-sm pd-x-15 btn-primary btn-uppercase mg-l-5"><i data-feather="sliders" class="wd-10 mg-r-5"></i> Settings</button>
                </div> --}}
            </div>

            <div class="row row-xs">
                <div class="col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="form-row">
                            <div class="col-md-6">
                                <div class="card-header pd-t-20 pd-b-0 bd-b-0">
                                    <h6 class="lh-5 mg-b-5">Overall Rating</h6>
                                    <p class="tx-12 tx-color-03 mg-b-0">Ratings is based on 152 total votes by Customer reviews on the quality of service provided by you.</p>

                                </div><!-- card-header -->

                                <div class="card-body pd-0">
                                    <div class="pd-t-10 pd-b-15 pd-x-20 d-flex align-items-baseline">
                                        <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5">4</h1>
                                        <div class="tx-18">
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-orange"></i>
                                            <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                                        </div>
                                    </div>
                                </div><!-- card-body -->
                            </div>
                            <div class="col-md-6">
                                <div class="card-body pd-t-10 pd-b-15 pd-x-20 mt-2">
                                    <h6 class="lh-5 mg-b-5">Your Earnings:<h1 class="tx-normal tx-rubik mg-b-0 mg-r-5"> ₦{{ number_format($payments->sum('amount')) }} </h1>
                                    </h6>
                                </div>
                            </div>
                        </div>

                        <div class="card-body pd-lg-25">
                            <div class="row">
                                <x-card cardtitle="Total Requests" cardnumber="{{ $total_request->count() }}" />
                                <x-card cardtitle="Completed Requests" cardnumber="{{ $completed_request->count() }}" />
                                <x-card cardtitle="Ongoing Requests" cardnumber="{{ $ongoing_request->count() }}" />
                                <x-card cardtitle="Pending Consultations" cardnumber="{{ $pending_consultations->count() }}" />
                                <x-card cardtitle="Completed Consultations" cardnumber="{{ $completed_consultations->count() }}" />
                                <x-card cardtitle="Payment Received" cardnumber="{{ $payments->count() }}" />
                            </div>
                        </div>

                    </div><!-- card -->
                </div>
          
                <div class="col-md-12 col-xl-12 mg-t-10">

                    <div class="card ht-100p">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h6 class="mg-b-0">Recent Payments</h6>
                            {{-- <div class="d-flex tx-18">
                              <a href="" class="link-03 lh-0"><i class="icon ion-md-refresh"></i></a>
                              <a href="" class="link-03 lh-0 mg-l-10"><i class="icon ion-md-more"></i></a>
                            </div> --}}
                        </div>
                        {{-- @if(Auth::user()->payments->count() > 0) --}}
                        <ul class="list-group list-group-flush tx-13">
                            {{-- @foreach(Auth::user()->payments as $payment) --}}
                            <li class="list-group-item d-flex pd-sm-x-20">
                                <div class="avatar d-none d-sm-block"><span class="avatar-initial rounded-circle bg-teal"><i class="icon ion-md-checkmark"></i></span></div>
                                <div class="pd-sm-l-10">
                                    <p class="tx-medium mg-b-0">Payment from FixMaster for TRF-345232 job</p>
                                    <small class="tx-12 tx-color-03 mg-b-0">Today's date</small>
                                </div>
                                <div class="mg-l-auto text-right">
                                    <p class="tx-medium mg-b-0"> ₦{{number_format(0)}}</p>
                                    <small class="tx-12 tx-success mg-b-0">Completed</small>
                                </div>
                            </li>
                        </ul>
                        <div class="card-footer text-center tx-13">
                            <a href="{{ route('technician.payments',app()->getLocale()) }}" class="link-03">View All Transactions <i class="icon ion-md-arrow-down mg-l-5"></i></a>
                        </div><!-- card-footer -->

                    </div><!-- card -->
                </div>


            </div><!-- row -->
        </div><!-- container -->
    </div>

@endsection



