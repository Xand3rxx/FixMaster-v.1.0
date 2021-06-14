@extends('layouts.dashboard')
@section('title', Auth::user()->type->role->name.' Dashboard' ?? 'Technicians & Artisans Dashboard')
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
        <h4 class="mg-b-0 tx-spacing--1">Welcome to Fix<span style="color: #E97D1F;">Master</span> {{ Auth::user()->type->role->name ?? 'Supplier' }} Dashboard</h4>
        {{-- <h4 class="mg-b-0 tx-spacing--1">Welcome  Dashboard</h4> --}}
      </div>
    
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
                  <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5">{{ !empty(round($profile['ratings']->avg('star'))) ? round($profile['ratings']->avg('star')) : '0' }}</h1>
                  <div class="tx-18">
                    @for ($i = 0; $i < round($profile['ratings']->avg('star')); $i++)
                      <i class="icon ion-md-star lh-0 tx-orange"></i>
                    @endfor
                    @for ($x = 0; $x < (5 - round($profile['ratings']->avg('star'))); $x++)
                        <i class="icon ion-md-star lh-0 tx-gray-300"></i>
                    @endfor
                  </div>
                </div>
              </div><!-- card-body -->
            </div>
            <div class="col-md-6">
              <div class="card-body pd-t-10 pd-b-15 pd-x-20 mt-2">
                <h6 class="lh-5 mg-b-5">Your ID:  <h1 class="tx-normal tx-rubik mg-b-0 mg-r-5"> {{ $profile['supplier']['unique_id'] }} </h1>
                </h6>
              </div>
            </div>
          </div>

          <div class="card-body pd-lg-25">
            <div class="row">
            <x-card cardtitle="Sent Quotes" cardnumber="{{ !empty($profile['supplierSentInvoices']) ? number_format($profile['supplierSentInvoices']->count()) : '0' }}" />
              <x-card cardtitle="Approved Quotes" cardnumber="{{ !empty($profile['supplierSentInvoices']) ? number_format($profile['supplierSentInvoices']->where('accepted', 'Yes')->count()) : '0' }}" />
              <x-card cardtitle="Amount Earned" cardnumber="₦{{  !empty($profile['supplierSentInvoices']) ?number_format(CustomHelpers::getTotalAmmount($profile, $causalAgentAmt)) : 0}}" />
            </div>
          </div>
          
        </div><!-- card -->
      </div>

      <div class="col-md-12 col-xl-12 mg-t-10">
        
        <div class="card ht-100p">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="mg-b-0">New Quotes</h6>
          </div>
          
          <div class="table-responsive">
            
            <table class="table table-hover mg-b-0">
              <thead class="thead-primary">
                <tr>
                  <th class="text-center">#</th>
                  <th>Job Ref.</th>
                  <th>Batch Number</th>
                  <th>Issued By</th>
                  <th>Status</th>
                  <th>Date Created</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rfqs as $rfq)
                <tr>
                  <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                  <td class="tx-medium">{{ $rfq->serviceRequest->unique_id }}</td>
                  <td class="tx-medium">{{ $rfq->unique_id }}</td>
                  <td class="tx-medium">{{ Str::title($rfq['issuer']['account']['first_name'] ." ". $rfq['issuer']['account']['last_name']) }}</td>
                  @if($rfq->status == 'Pending')
                    <td class="text-medium text-success">Open</td>
                  @else
                    <td class="text-medium text-danger">Closed</td>
                  @endif
                  {{-- <td class="tx-medium text-center">₦{{ number_format($rfq->total_amount) ?? 'Null'}}</td> --}}
                  <td class="text-medium">{{ Carbon\Carbon::parse($rfq->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  <td class=" text-center">
                    <div class="dropdown-file">
                      <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#rfqDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $rfq->unique_id}} details" data-batch-number="{{ $rfq->unique_id}}" data-url="{{ route('supplier.rfq_details', ['rfq'=>$rfq->uuid, 'locale'=>app()->getLocale()]) }}" id="rfq-details"><i class="far fa-clipboard"></i> Details</a>

                        @if($rfq->status == 'Pending')
                          <a href="{{ route('supplier.rfq_send_supplier_invoice', ['rfq'=>$rfq->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success" title="Send {{ $rfq->unique_id}} invoice"><i class="fas fa-file-medical"></i> Send Invoice</a>
                        @endif
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-responsive -->

        </div><!-- card -->
      </div>

      {{-- <div class="col-md-12 col-xl-12 mg-t-10">
        
        <div class="card ht-100p">
          <div class="card-header d-flex align-items-center justify-content-between">
            <h6 class="mg-b-0">Recent Payments</h6>
            {
          </div>
          <ul class="list-group list-group-flush tx-13">
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
          <a href="{{ route('quality-assurance.payments',app()->getLocale()) }}" class="link-03">View All Transactions <i class="icon ion-md-arrow-down mg-l-5"></i></a>
          </div><!-- card-footer -->
          
        </div><!-- card -->
      </div> --}}


    </div><!-- row -->
  </div><!-- container -->
</div>

@include('supplier.rfq._rfq_details_modal')


@endsection
