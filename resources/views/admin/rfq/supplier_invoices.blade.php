@extends('layouts.dashboard')
@section('title', 'Supplier RFQ Invoices')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">RFQ</li>
            <li class="breadcrumb-item active" aria-current="page">Supplier RFQ's Invoices</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Supplier RFQ's Invoices </h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">Supplier RFQ's Invoices as of {{ date('M, d Y') }}</h6>
              <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Invoices sent by all FixMaster Suppliers regarding RFQ's initiated by CSE's.</p>
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
                  <th>Type</th>
                  <th>Supplier</th>
                  {{-- <th>Delivery Fee(₦)</th> --}}
                  <th class="tx-center">Total Amount(₦)</th>
                  <th>Delivery Time</th>
                  <th class="tx-center">Distance</th>
                  <th class="tx-center">Acceptance Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rfqs as $items)
                  @foreach ($items as $rfq)
                    <tr>
                      <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                      <td class="tx-medium">{{ $rfq['rfq']['serviceRequest']['unique_id'] }}</td>
                      <td class="tx-medium">{{ $rfq['rfq']['unique_id'] }}</td>
                      <td class="tx-medium">{{ Str::title($rfq['rfq']['issuer']['account']['first_name'] ." ". $rfq['rfq']['issuer']['account']['last_name']) }}</td>
                      <td class="tx-medium">{{ $rfq['rfq']['type'] }}</td>
                      <td class="tx-medium">{{ Str::title($rfq['supplier']['account']['first_name'] ." ". $rfq['supplier']['account']['last_name']) }}</td>
                      {{-- <td class="tx-medium tx-center">{{ $rfq->delivery_fee }}</td> --}}
                      <td class="tx-medium tx-center">{{ $rfq->total_amount }}</td>
                      <td class="text-medium">{{ Carbon\Carbon::parse($rfq->delivery_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                      <td class="text-center text-success">{{ App\Http\Controllers\Admin\RfqController::getDistanceBetweenPoints($rfq['rfq']['serviceRequest']['client']['contact']['address_latitude'], $rfq['rfq']['serviceRequest']['client']['contact']['address_longitude'], $rfq['supplier']['contact']['address_latitude'], $rfq['supplier']['contact']['address_longitude']) }}km</td>
                      @if($rfq['accepted'] == 'Yes')
                        <td class="tx-center text-success">Accepted</td>
                      @elseif($rfq['accepted'] == 'No'))
                        <td class="tx-center text-danger">Declined</td>
                      @else
                        <td class="tx-center text-warning">Pending</td>
                      @endif
                      <td class="text-center">
                        <div class="dropdown-file">
                          <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                          <div class="dropdown-menu dropdown-menu-right">

                            <a href="#rfqDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $rfq->rfq->unique_id}} details" data-batch-number="{{ $rfq->rfq->unique_id}}" data-url="{{ route('admin.supplier_invoices_details', ['rfq'=>$rfq->uuid, 'locale'=>app()->getLocale()]) }}" id="rfq-details"><i class="far fa-clipboard"></i> Details</a>
                          
                            @if($rfq->rfq->status == 'Pending')
                              <a href="{{ route('admin.supplier_invoices_acceptance', ['rfq'=>$rfq->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success" title="Accept {{ $rfq->rfq->unique_id}} invoice"><i class="fas fa-check"></i> Accept</a>
                            @endif
                          </div>
                        </div>
                      </td>
                    </tr>
                  @endforeach
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