@extends('layouts.dashboard')
@section('title', 'CSE Payments')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('quality-assurance.index',app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Payments</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Payments</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">Your Most Recent Requests</h6>
            <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of <strong>Payments</strong> made by <span>FixMaster</span> as of <strong>{{ date('l jS F Y') }}</strong>.</p>
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
                  <h4 class="tx-20 tx-sm-18 tx-md-20 tx-normal tx-rubik mg-b-0">1</h4>
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
                            <option>Select...</option>
                            <option value="2018">2018</option>
                            <option value="2019">2019</option>
                            <option value="2020">2020</option>
                            <option value="2021">2021</option>
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

              <table class="table table-hover mg-b-0" id="basicExample">
                <thead class="thead-primary">
                  <tr>
                    <th class="text-center">#</th>
                    <th>Job Reference</th>
                    <th>Reference No</th>
                    <th>Paid By</th>
                    <th>Amount</th>
                    <th>Payment Mode</th>
                    <th>Comment</th>
                    <th class="text-center">Payment Date</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                    <td class="tx-color-03 tx-center">1</td>
                    <td class="tx-medium">REF-234234723</td>
                      <td class="tx-medium">32e3lh2e23083h432b</td>
                      <td class="tx-medium">David Akinsola</td>
                      <td class="tx-medium">₦{{ number_format(10000) }}</td>
                      <td class="tx-medium">Bank Transfer</td>
                      <td class="text-medium">This payment was made because of your successful task completion on job REF-234234723</td>
                      <td class="text-medium tx-center">{{ Carbon\Carbon::parse('2020-12-28 16:58:54', 'UTC')->isoFormat('MMMM Do YYYY') }}</td>
                    </tr>
                </tbody>
              </table>
            </div><!-- table-responsive -->
          </div><!-- table-responsive -->
        </div><!-- card -->

      </div><!-- col -->
    </div><!-- row -->


  </div><!-- container -->
</div>
@endsection
@section('scripts')
<script src="{{ asset('assets/dashboard/assets/js/qa-payments-sortings.js') }}"></script>
 <script>
    //$(document).ready(function() {

//         $('#request-sorting').on('change', function (){
//                 let option = $("#request-sorting").find("option:selected").val();

//                 if(option === 'None'){
//                     $('.specific-date, .sort-by-year, .date-range').addClass('d-none');
//                 }

//                 if(option === 'Date'){
//                     $('.specific-date').removeClass('d-none');
//                     $('.sort-by-year, .date-range').addClass('d-none');
//                 }

//                 if(option === 'Month'){
//                     $('.sort-by-year').removeClass('d-none');
//                     $('.specific-date, .date-range').addClass('d-none');
//                 }

//                 if(option === 'Date Range'){
//                     $('.date-range').removeClass('d-none');
//                     $('.specific-date, .sort-by-year').addClass('d-none');
//                 }
//         });
//     });

</script>
@endsection

