@extends('layouts.dashboard')
@section('title', 'Sent Invoices')
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
            <li class="breadcrumb-item active" aria-current="page">Sent Invoices</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Sent Invoices </h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">Sent Invoice's as of {{ date('M, d Y') }}</h6>
              <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all Invoices you sent regarding RFQ's initiated by CSE's.</p>
            </div>
            
          </div><!-- card-header -->

     
         
          <div class="table-responsive">
            
            <table class="table table-hover mg-b-0" id="basicExample">
              <thead class="thead-primary">
                <tr>
                  <th class="text-center">#</th>
                  <th>Job Ref.</th>
                  <th>Batch Number</th>
                  <th class="tx-center">Delivery Fee(₦)</th>
                  <th class="tx-center">Total Amount(₦)</th>
                  <th>Delivery Time</th>
                  <th>Status</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($rfqs as $rfq)
                <tr>
                  <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                  <td class="tx-medium">{{ $rfq->rfq->serviceRequest->unique_id }}</td>
                  <td class="tx-medium">{{ $rfq->rfq->unique_id }}</td>
                  <td class="tx-medium tx-center">{{ $rfq->delivery_fee }}</td>
                  <td class="tx-medium tx-center">{{ $rfq->total_amount }}</td>
                  <td class="text-medium">{{ Carbon\Carbon::parse($rfq->delivery_time, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                  @if($rfq->accepted == 'Yes')
                    <td class="text-medium text-success">Approved</td>
                  @elseif($rfq->accepted == 'No')
                    <td class="text-medium text-danger">Declined</td>
                  @else
                    <td class="text-medium text-warning">Pending</td>
                  @endif
                  <td class=" text-center">
                    <div class="dropdown-file">
                      <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                      <div class="dropdown-menu dropdown-menu-right">

                        <a href="#rfqDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $rfq->rfq->unique_id}} details" data-batch-number="{{ $rfq->rfq->unique_id}}" data-url="{{ route('supplier.sent_supplier_invoice_details', ['rfq'=>$rfq->id, 'locale'=>app()->getLocale()]) }}" id="rfq-details"><i class="far fa-clipboard"></i> Details</a>

                        @if($rfq->rfq->accepted == 'Yes')
                          <a href="#dispatch" data-toggle="modal" class="dropdown-item details text-success" title="Dispatch {{ $rfq->rfq->unique_id}}" data-rfq="{{ $rfq->rfq->unique_id }}" data-rfq-id="{{ $rfq->rfq->id }}"  data-supplier-invoice="{{ $rfq->id }}" id="dispatch"><i class="fa fa-paper-plane"></i> Dispatch</a>
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

  <div class="modal fade" id="rfqDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel2">Request For Qoute Details</h6>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body" id="modal-body">
            <!-- Modal displays here -->
            <div id="spinner-icon"></div>
        </div>
      </div>
    </div>
  </div>


  
</div>
@include('supplier.rfq._rfq_details_modal')


@push('scripts')
<script src="{{ asset('assets/dashboard/assets/js/a784c9e7-4015-44df-994d-50ffe4921458.js') }}"></script>

<script>
  $(document).ready(function() {

    $('.close').click(function (){
      $(".modal-backdrop").remove();
    });

  });
</script>

@endpush

@endsection