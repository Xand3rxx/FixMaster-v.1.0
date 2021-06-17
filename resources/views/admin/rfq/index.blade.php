@extends('layouts.dashboard')
@section('title', 'Request For Quote(RFQ)')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">RFQ</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Request for Quotation(RFQ) </h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">RFQ's as of {{ date('M, d Y') }}</h6>
              <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster RFQ's initiated by CSE's.</p>
            </div>
            
          </div><!-- card-header -->
         
          <div class="table-responsive">
            
            <table class="table table-hover mg-b-0" id="basicExample">
              <thead class="thead-primary">
                <tr>
                  <th class="text-center">#</th>
                  <th>Job Ref.</th>
                  <th>Batch Number</th>
                  <th>Client</th>
                  <th>Issued By</th>
                  <th>Type</th>
                  <th>Status</th>
                  <th class="text-center">Total Amount(₦)</th>
                  <th>Date Created</th>
                  <th>Action</th>
                </tr>
              </thead>
              {{-- Status: 0 => Awaiting total amount, 1 => Awaiting Client's payment, 2 => Payment received --}}
              <tbody>
                @foreach ($rfqs as $rfq)
                <tr>
                  <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                  <td class="tx-medium">{{ $rfq['serviceRequest']['unique_id'] }}</td>
                  <td class="tx-medium">{{ $rfq['unique_id'] }}</td>
                  <td class="tx-medium">{{ Str::title($rfq['serviceRequest']['client']['account']['first_name'] ." ". $rfq['serviceRequest']['client']['account']['last_name']) }}</td>
                  <td class="tx-medium">{{ Str::title($rfq['issuer']['account']['first_name'] ." ". $rfq['issuer']['account']['last_name']) }}</td>
                  <td class="tx-medium">{{ $rfq->type }}</td>
                  @if($rfq->status == 'Pending')
                    <td class="text-medium text-warning">Awaiting Supplier's invoices</td>
                  @elseif($rfq->status == 'Awaiting')
                    <td class="text-medium text-info">Awaiting Supplier's delivery</td>
                  @elseif($rfq->status == 'Delivered')
                    <td class="text-medium text-success">RFQ has been Delivered</td>
                  @elseif($rfq->status == 'Rejected')
                    <td class="text-medium text-success">RFQ was rejected</td>
                  @endif
                  <td class="tx-medium text-center">{{ number_format($rfq['total_amount']) ?? 'Null'}}</td>
                  <td class="text-medium">{{ Carbon\Carbon::parse($rfq['created_at'], 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  <td class=" text-center">
                    <div class="dropdown-file">
                      <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                      <div class="dropdown-menu dropdown-menu-right">
                        <a href="#rfqDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $rfq['unique_id']}} details" data-batch-number="{{ $rfq['unique_id']}}" data-url="{{ route('admin.rfq_details', ['rfq'=>$rfq->uuid, 'locale'=>app()->getLocale()]) }}" id="rfq-details"><i class="far fa-clipboard"></i> Details</a>
                      </div>
                    </div>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div><!-- table-responsive -->
        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->

  </div><!-- container -->

</div>

@include('admin.rfq._rfq_details_modal')

@endsection