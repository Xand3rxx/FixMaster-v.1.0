@extends('layouts.dashboard')
@section('title', 'Activity Log')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Activity Log</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">All Activity Log</h4>
        </div>
      </div>

      <div class="row row-xs">
        <div class="col-lg-12 col-xl-12 mg-t-10">
          <div class="card mg-b-10">
            <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
              <div>
                <h6 class="mg-b-5">Activity Log</h6>
                <p class="tx-13 tx-color-03 mg-b-0">Use the select dropdowns to sort Activity Logs.</p>
              </div>
              
            </div><!-- card-header -->
           
            <div class="table-responsive">
              <div class="row mt-1 mb-1 ml-1 mr-1">
                <input value="{{ Auth::id() }}" type="hidden" id="user_id">
                <input value="{{ route("admin.activity-log.sorting_users", app()->getLocale()) }}" type="hidden" id="route">
               
                  <div class="col-md-3">
                    <div class="form-group">
                        <label>Sort Type</label>
                        <select class="custom-select" id="activity_log_type">
                            <option selected value="None">Select...</option>
                            <option value="Errors">Errors</option>
                            <option value="Login">Login</option>
                            <option value="Logout">Logout</option>
                            <option value="Others">Others</option>
                            <option value="Payments">Payments</option>
                            <option value="Profile">Profile</option>
                            <option value="Request">Requests</option>
                            <option value="Unauthorized">Unauthorized</option>
                        </select>
                    </div>
                  </div><!--end col-->
    
    
                  <div class="col-md-3">
                      <div class="form-group">
                          <label>Sort Date</label>
                          <select class="custom-select" id="sort_by_range">
                              <option value="None">Select...</option>
                              <option value="Date">Date</option>
                              <option value="Month">Month</option>
                              <option value="Year">Year</option>
                              <option value="Date Range">Date Range</option>
                          </select>
                      </div>
                  </div><!--end col-->
      
                  <div class="col-md-3 specific-date d-none">
                      <div class="form-group position-relative">
                          <label>Specify Date <span class="text-danger">*</span></label>
                          <input name="name" id="specific_date" type="date" class="form-control pl-5">
                      </div>
                  </div>
      
                  <div class="col-md-3 sort-by-year d-none">
                      <div class="form-group position-relative">
                          <label>Specify Year <span class="text-danger">*</span></label>
                          <select class="form-control custom-select" id="sort_by_year">
                              <option value="">Select...</option>
                              @foreach ($years as $year)
                                <option value="{{ $year }}">{{ $year }}</option>
                              @endforeach
                          </select>
                      </div>
                  </div>
      
                  <div class="col-md-3 sort-by-year d-none" id="sort-by-month">
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
      
                  <div class="col-md-3 date-range d-none">
                      <div class="form-group position-relative">
                          <label>From <span class="text-danger">*</span></label>
                          <input name="name" id="date_from" type="date" class="form-control pl-5">
                      </div>
                  </div>
      
                  <div class="col-md-3 date-range d-none">
                      <div class="form-group position-relative">
                          <label>To <span class="text-danger">*</span></label>
                          <input name="name" id="date_to" type="date" class="form-control pl-5">
                      </div>
                  </div>
                </div>
  
                <div id="sort_table">
                  @include('admin.activitylog._activity_log_table')
                </div>
            </div><!-- table-responsive -->

            {{-- <div class="float-right">
              <span class="d-flex justify-content-end">{{ $activityLogs->links() }}</span>
            </div> --}}
          </div><!-- card -->
          
        </div><!-- col -->
      </div><!-- row -->
      
    </div>
</div>

@push('scripts')
    <script src="{{ asset('assets/dashboard/assets/js/599f0f6e-4ee4-4484-94b2-709f52573447.js') }}"></script>
@endpush

@endsection