@extends('layouts.dashboard')
@section('title', 'Warranty Claims Request  For Qoute')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            {{-- <li class="breadcrumb-item active" aria-current="page">RFQ's</li> --}}
            <li class="breadcrumb-item active" aria-current="page">New RFQ's</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Warranty Claims Request for Quotation(RFQ) </h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">Warranty Claims RFQ's as of {{ date('M, d Y') }}</h6>
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
                  <th>Issued By</th>
                  <th>Status</th>
                  {{-- <th class="text-center">Total Amount</th> --}}
                  <th>Date Created</th>
                  <th>Action</th>
                </tr>
              </thead>
              {{-- Status: 0 => Awaiting total amount, 1 => Awaiting Client's payment, 2 => Payment received --}}
              <tbody>
       
                @foreach ($rfqs as $rfq)
                <tr>
                  <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                  <td class="tx-medium">{{ $rfq->serviceRequest->unique_id }}</td>
                  <td class="tx-medium">{{ $rfq->unique_id }}</td>
                  <td class="tx-medium">{{ Str::title($rfq['issuer']['account']['first_name'] ." ". $rfq['issuer']['account']['last_name']) }}</td>
                  @if($rfq->status == 'Awaiting' && is_null($rfq->rfqSupplierInvoice))
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
                      @if(!$rfq->status == 'Awaiting')
                        <a href="#rfqDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $rfq->unique_id}} details" data-batch-number="{{ $rfq->unique_id}}" data-url="{{ route('supplier.rfq_warranty_details', ['rfq'=>$rfq->uuid, 'locale'=>app()->getLocale()]) }}" id="rfq-details"><i class="far fa-clipboard"></i> Details</a>
                        @endif
                        @if($rfq->status == 'Awaiting' && is_null($rfq->rfqSupplierInvoice))
                          <a href="{{ route('supplier.rfq_warranty_send_supplier_invoice', ['rfq'=>$rfq->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success" title="Send {{ $rfq->unique_id}} invoice"><i class="fas fa-file-medical"></i> Send Invoice</a>
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

      </div><!-- col -->
    </div><!-- row -->

  </div><!-- container -->

 

</div>

@include('supplier.rfq.warranty._rfq_details_modal')

@endsection