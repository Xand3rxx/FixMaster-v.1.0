@extends('layouts.dashboard')
@section('title', 'Disbursed Payments')
@include('layouts.partials._messages')
<style>
table thead th:nth-child(26), table tbody td:nth-child(26) {
    position: sticky;
    right: 0;
}

table thead th:nth-child(26) {
    background: #e97d1f;
	}

table tbody td:nth-child(26) {
    background: #ffffff;
	}

</style>
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('quality-assurance.index',app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Disbursed Payments</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Disbursed Payments</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">Your Most Recent Requests</h6>
            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of pending<strong>Payments</strong> to be paid by <span>FixMaster</span> as of <strong>{{ date('l jS F Y') }}</strong>.</p>
            </div>

          </div><!-- card-header -->
          <div class="card-body pd-y-30">
            <div class="d-sm-flex">
              <div class="media">
                <div class="wd-40 wd-md-50 ht-40 ht-md-50 bg-teal tx-white mg-r-10 mg-md-r-10 d-flex align-items-center justify-content-center rounded op-6">
                  <i data-feather="bar-chart-2"></i>
                </div>
                <div class="media-body">
                  <h6 class="tx-sans tx-uppercase tx-10 tx-spacing-1 tx-color-03 tx-semibold tx-nowrap mg-b-5 mg-md-b-8">Total Payments</h6>
                  <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">{{$disbursedPayments->count()}}</h4>
                </div>
              </div>

            </div>
          </div><!-- card-body -->
          <div class="table-responsive">
            <div class="row mt-1 mb-1 ml-1 mr-1">
                <div class="col-md-4">
                    <input value="{{ route("quality-assurance.disbursed_payments_sorting", app()->getLocale()) }}" type="hidden" id="route">
                    <div class="form-group">
                        <label>Sort</label>
                        <select class="custom-select" id="sort_by_range">
                            <option value="None">Select...</option>
                            <option value="Date">Date</option>
                            <option value="Month">Month</option>
                            <option value="Year">Year</option>
                            <option value="Date Range">Date Range</option>
                        </select>
                    </div>
                </div><!--end col-->

                <div class="col-md-4 specific-date d-none">
                    <div class="form-group position-relative">
                        <label>Specify Date <span class="text-danger">*</span></label>
                        <input name="name" id="specific_date" type="date" class="form-control s_date pl-5">
                    </div>
                </div>

                <div class="col-md-4 sort-by-year d-none">
                    <div class="form-group position-relative">
                        <label>Specify Year <span class="text-danger">*</span></label>
                        <select class="form-control custom-select" id="sort_by_year">
                            <option value="">Select...</option>
                            {{-- @foreach ($years as $year)
                              <option value="{{ $year }}">{{ $year }}</option>
                            @endforeach --}}
                        </select>
                    </div>
                </div>

                <div class="col-md-4 sort-by-year d-none" id="sort-by-month">
                    <div class="form-group position-relative">
                        <label>Specify Month <span class="text-danger">*</span></label>
                        <select class="form-control custom-select" id="sort_by_month">
                            <option value="">Select...</option>
                            <option value="January">January</option>
                            <option value="February">February</option>
                            <option value="March">March</option>
                            <option value="April">April</option>
                            <option value="May">May</option>
                            <option value="June">June</option>
                            <option value="July">July</option>
                            <option value="August">August</option>
                            <option value="September">September</option>
                            <option value="October">October</option>
                            <option value="November">November</option>
                            <option value="December">December</option>
                        </select>
                    </div>
                  </div>

                <div class="col-md-4 date-range d-none">
                    <div class="form-group position-relative">
                        <label>From <span class="text-danger">*</span></label>
                        <input id="date_from" type="date" class="form-control pl-5">
                    </div>
                </div>

                <div class="col-md-4 date-range d-none">
                    <div class="form-group position-relative">
                        <label>To <span class="text-danger">*</span></label>
                        <input id="date_to" type="date" class="form-control pl-5">
                    </div>
                </div>
              </div>

              <div id="sort_table">
              {{-- @include('quality-assurance._disbursed_table') --}}

              {{-- <div class="d-flex ml-4"><h4 class="text-success">{{ !empty($message)? $message: '' }}</h4></div> --}}
<table class="table table-hover mg-b-0" id="basicExample">
    <thead class="thead-primary">
    {{-- {{$payment}} --}}
      <tr>
        <tr>
            <th class="text-center">#</th>
            <th>Job ID</th>
            <th>Service Category</th>
            <th>Service Type</th>
            <th>CSE Name</th>
            <th>CSE Nuban</th>
            <th>CSE Bank</th>
            <th>CSE Amount</th>
            <th>QA Name</th>
            <th>QA Nuban</th>
            <th>QA Bank</th>
            <th>QA Amount</th>
            <th>Technician Name</th>
            <th>Technician Nuban</th>
            <th>Technician Bank</th>
            <th>Technician Amount</th>
            <th>Supplier Name</th>
            <th>Supplier Nuban</th>
            <th>Supplier Bank</th>
            <th>Supplier Amount</th>
            <th>Retention Fee</th>
            <th>Amount After Retention</th>
            <th>Amount to be Paid</th>
            <th>Status</th>
            <th class="text-center">Date of Completion</th>
            <th>Action</th>
          </tr>
      </tr>
    </thead>
    <tbody>

        @foreach($disbursedPayments as $payment)
        <tr>

            <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
            <td class="tx-medium">{{$payment['service_request']['unique_id']}}</td>
              <td class="tx-medium">{{$payment['service_request']['service']['name']}}</td>
              <td class="tx-medium">{{$payment['service_type']}}</td>
              @foreach($payment['users']['roles'] as $role)
                @if($role['name'] == 'Customer Service Executive')
                {{-- for CSEs --}}
                    <td class="tx-medium">{{$payment['users']['account']['first_name'].' '.$payment['users']['account']['middle_name'].' '.$payment['users']['account']['last_name'] ?? 'Unavailable'}}</td>
                    <td class="tx-medium">{{!empty($payment['users']['account']['account_number']) ? $payment['users']['account']['account_number'] : 'Unavailable'}}</td>
                    <td class="tx-medium">{{!empty($payment['users']['account']['bank']['name']) ? $payment['users']['account']['bank']['name'] : 'Unavailable'}}</td>
                    <td class="tx-medium">&#8358;{{!empty($payment['flat_rate']) ? number_format($payment['flat_rate'],2) : 'Unavailable'}}</td>
                @else
                <td class="tx-medium">Unavailable</td>
                <td class="tx-medium">Unavailable</td>
                <td class="tx-medium">Unavailable</td>
                <td class="tx-medium">Unavailable</td>
                @endif

                {{-- for QAs --}}
                 @if($role['name'] == 'Quality Assurance Manager')
                 <td class="tx-medium">{{$payment['users']['account']['first_name'].' '.$payment['users']['account']['middle_name'].' '.$payment['users']['account']['last_name'] ?? 'Unavailable'}}</td>
                 <td class="tx-medium">{{!empty($payment['users']['account']['account_number']) ? $payment['users']['account']['account_number'] : 'Unavailable'}}</td>
                 <td class="tx-medium">{{$payment['users']['account']['bank']['name']}}</td>
                 <td class="tx-medium">&#8358;{{number_format($payment['flat_rate'],2)}}</td>
                 @else
                 <td class="tx-medium">Unavailable</td>
                 <td class="tx-medium">Unavailable</td>
                 <td class="tx-medium">Unavailable</td>
                 <td class="tx-medium">Unavailable</td>
                 @endif

                  @if($role['name'] == 'Technicians & Artisans')
              {{-- for Technicians --}}
                    <td class="tx-medium">{{$payment['users']['account']['first_name'].' '.$payment['users']['account']['middle_name'].' '.$payment['users']['account']['last_name']}}</td>
                    <td class="tx-medium">{{$payment['users']['account']['account_number']}}</td>
                    <td class="tx-medium">{{$payment['users']['account']['bank']['name']}}</td>
                    <td class="tx-medium">&#8358;{{number_format($payment['actual_labour_cost'],2)}}</td>
                  @else
                  <td class="tx-medium">Unavailable</td>
                  <td class="tx-medium">Unavailable</td>
                  <td class="tx-medium">Unavailable</td>
                  <td class="tx-medium">Unavailable</td>
                @endif

                  @if($role['name'] == 'Suppliers')
                  <td class="tx-medium">{{$payment['users']['account']['first_name'].' '.$payment['users']['account']['middle_name'].' '.$payment['users']['account']['last_name']}}</td>
                  <td class="tx-medium">{{$payment['users']['account']['account_number']}}</td>
                  <td class="tx-medium">{{$payment['users']['account']['bank']['name']}}</td>
                  <td class="tx-medium">&#8358;{{number_format($payment['actual_material_cost'],2)}}</td>
                  @else
                   <td class="tx-medium">Unavailable</td>
                   <td class="tx-medium">Unavailable</td>
                   <td class="tx-medium">Unavailable</td>
                   <td class="tx-medium">Unavailable</td>
                  @endif

                  @if($role['name'] == 'Technicians & Artisans' || $role['name'] == 'Suppliers')

                    <td class="tx-medium">&#8358;{{number_format($payment['retention_fee'],2)}}</td>
                    <td class="tx-medium">&#8358;{{number_format($payment['amount_after_retention'],2)}}</td>

                  @else

                  <td class="tx-medium">Unavailable</td>
                  <td class="tx-medium">Unavailable</td>

                  @endif

                  <td class="tx-medium">&#8358;{{number_format($payment['amount_to_be_paid'],2)}}</td>
                  <td class="tx-medium">{{$payment['status']}}</td>
              @endforeach
              <td class="text-medium tx-center">{{ Carbon\Carbon::parse($payment->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
              {{-- <td><a href="#" data-toggle="modal" data-target="#transactionDetails" data-payment-ref="{{ $result->unique_id }}" data-url="{{ route('quality-assurance.payment_details', ['payment' => $result->id, 'locale' => app()->getLocale()]) }}" id="payment-details" class="btn btn-primary btn-sm ">Details</a></td> --}}
               <td><a href="#" id="" class="btn btn-primary btn-sm ">Details</a></td>
            </tr>
        @endforeach
    </tbody>
  </table>
              </div>
          </div><!-- table-responsive -->
        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->
    <div class="modal fade" id="transactionDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="true" data-backdrop="static">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
          <div class="modal-content tx-14">
            <div class="modal-header">
              <h6 class="modal-title" id="exampleModalLabel2">Payment Details</h6>
                <a href="" role="button" class="close pos-absolute t-15 r-15" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </a>
            </div>
                <div class="modal-body pd-x-25 pd-sm-x-30 pd-t-40 pd-sm-t-20 pd-b-15 pd-sm-b-20" id="modal-body">

                    <div id="spinner-icon"></div>
              </div><!-- modal-body -->
            <div class="modal-footer"></div>
          </div>
        </div>
    </div>
  </div><!-- container -->
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/dashboard/assets/js/qa-payments-sortings.js') }}"></script>

<script>
    $(document).ready(function() {

        $(document).on('click', '#payment-details', function(event) {
            event.preventDefault();
            let route = $(this).attr('data-url');
            let paymentRef = $(this).attr('data-payment-ref');

            $.ajax({
                url: route,
                beforeSend: function() {
                    $("#modal-body").html('<div class="d-flex justify-content-center mt-4 mb-4"><span class="loadingspinner"></span></div>');
                },
                // return the result
                success: function(result) {
                    $('#modal-body').modal("show");
                    $('#modal-body').html('');
                    $('#modal-body').html(result).show();
                },
                complete: function() {
                    $("#spinner-icon").hide();
                },
                error: function(jqXHR, testStatus, error) {
                    var message = error+ ' An error occured while trying to retireve '+ paymentRef +' record.';
                    var type = 'error';
                    displayMessage(message, type);
                    $("#spinner-icon").hide();
                },
                timeout: 8000
            })
        });
        $('.close').click(function (){
            $(".modal-backdrop").remove();
        });
    });
</script>
@endsection

