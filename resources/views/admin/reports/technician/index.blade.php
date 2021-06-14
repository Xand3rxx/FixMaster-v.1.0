@extends('layouts.dashboard')
@section('title', 'Customer Service Executive Reports')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/bootstrap-multiselect.css') }}">

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item" aria-current="page">Reports</li>
            <li class="breadcrumb-item active" aria-current="page">Technician</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Technician Reports</h4>
      </div>
    </div>

    <div class="contact-content-header mt-4">
      <nav class="nav">
        <a href="#job_assigned" class="nav-link active" data-toggle="tab">Job Assigned</a>
        <a href="#amount_earned" class="nav-link" data-toggle="tab"><span>Amount Earned</a>
        <a href="#technician_list" class="nav-link" data-toggle="tab"><span>List of Technicians</a>
        <a href="#rating_history" class="nav-link" data-toggle="tab"><span>Technicians Rating History</a>
        <a href="#statement_balance" class="nav-link" data-toggle="tab"><span>Statement Balance</a>
        <a href="#unpaid_amount" class="nav-link" data-toggle="tab"><span>Unpaid Amount per Job</a>
        {{-- <a href="#customer_complaints" class="nav-link" data-toggle="tab"><span>List of Customer Complaints</a> --}}
        <a href="#job_warranty_logs" class="nav-link" data-toggle="tab"><span>Job Warranty Log</a>
      </nav>
    </div><!-- contact-content-header -->

    <div class="contact-content-body">
      <div class="tab-content">
        <div id="job_assigned" class="tab-pane show active pd-20 pd-xl-25">
          <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
              <div class="card mg-b-10">
                <div class="d-sm-flex mg-t-10"></div>

                <div class="row mt-1 mb-1 ml-1 mr-1">
                  <div class="col-md-4">
                    <input type="hidden" class="d-none" id="route" value="{{ route('admin.technician_report_first_sorting', app()->getLocale()) }}">
                    <div class="form-group">
                      <label>Sorting Parameters</label>
                      <select class="custom-select" id="sorting-parameters">
                        <option value="" disabled selected>Select...</option>
                        <option value="SortType1">Technician Name</option>
                        <option value="SortType2">Job Acceptance Date</option>
                        <option value="SortType3">Job Completion Date</option>
                        <option value="SortType4">Job Status</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 cse-list d-none">
                    <div class="form-group position-relative">
                      <label>{{ !empty($technicians->name) ? $technicians->name : 'TECHNICIAN' }} List <span class="text-danger">*</span></label>
                      <select class="form-control selectpicker" multiple id="cse-list">
                        <option value="" disabled>Select...</option>
                        @foreach ($technicians['users'] as $technician)
                        <option value="{{ $technician['account']['user_id'] }}">{{ !empty($technician['account']['first_name']) ? Str::title($technician['account']['first_name'] ." ". $technician['account']['last_name']) : 'UNAVAILABLE' }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4 date-range d-none">
                    <div class="form-group position-relative">
                      <label>From <span class="text-danger">*</span></label>
                      <input name="date_from" id="date-from" type="date" class="form-control pl-5">
                    </div>
                  </div>

                  <div class="col-md-4 date-range d-none">
                    <div class="form-group position-relative">
                      <label>To <span class="text-danger">*</span></label>
                      <input name="date_to" id="date-to" type="date" class="form-control pl-5" max="{{ Carbon\Carbon::now('UTC') }}">
                    </div>
                  </div>

                  <div class="col-md-4 job-status d-none">
                    <div class="form-group position-relative">
                      <label>Job Status <span class="text-danger">*</span></label>
                      <select class="form-control" name="job_status" id="job-status">
                        <option value="">Select...</option>
                        <option value="1">Pending</option>
                        <option value="2">Ongoing</option>
                        <option value="3">Cancelled</option>
                        <option value="4">Completed</option>
                      </select>
                    </div>
                  </div>

                </div>

                <div class="table-responsive">
                  <div id="job-assigned-sorting">
                    @include('admin.reports.technician.tables._job_assigned')
                  </div>
                </div><!-- table-responsive -->
              </div><!-- card -->
            </div><!-- col -->
          </div><!-- row -->
        </div>

        <div id="amount_earned" class="tab-pane pd-20 pd-xl-25">
          <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
              <div class="card mg-b-10">
                <div class="d-sm-flex mg-t-10"></div>

                <div class="row mt-1 mb-1 ml-1 mr-1">
                  <div class="col-md-4">
                    <input type="hidden" class="d-none" id="assigned-route" value="{{ route('admin.cse_report_second_sorting', app()->getLocale()) }}">
                    <div class="form-group">
                      <label>Sorting Parameters</label>
                      <select class="custom-select" id="assigned-sorting-parameters">
                        <option value="" disabled selected>Select...</option>
                        <option value="SortType1">Technician Name</option>
                        <option value="SortType2">Diagnostic Date Range</option>
                        <option value="SortType3">Acceptance Date Range</option>
                        <option value="SortType4">Job Status</option>
                        <option value="SortType5">Paid Amount</option>
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 assigned-cse-list d-none">
                    <div class="form-group position-relative">
                      <label>{{ !empty($cses->name) ? '$cses->name' : 'CSE' }} List <span class="text-danger">*</span></label>
                      <select class="form-control selectpicker" multiple id="assigned-cse-list">
                        <option value="" disabled>Select...</option>
                        {{-- @foreach ($cses['users'] as $cse)
                        <option value="{{ '$cse['account']['user_id']' }}">{{ '!empty($cse['account']['first_name']') ? Str::title('$cse['account']['first_name']' ." ". '$cse['account']['last_name']') : 'UNAVAILABLE' }}</option>
                        @endforeach --}}
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4 assigned-date-range d-none">
                    <div class="form-group position-relative">
                      <label>From <span class="text-danger">*</span></label>
                      <input name="date_from" id="assigned-date-from" type="date" class="form-control pl-5">
                    </div>
                  </div>

                  <div class="col-md-4 assigned-date-range d-none">
                    <div class="form-group position-relative">
                      <label>To <span class="text-danger">*</span></label>
                      <input name="date_to" id="assigned-date-to" type="date" class="form-control pl-5" max="{{ Carbon\Carbon::now('UTC') }}">
                    </div>
                  </div>

                  <div class="col-md-4 assigned-job-status d-none">
                    <div class="form-group position-relative">
                      <label>Job Status <span class="text-danger">*</span></label>
                      <select class="form-control" name="job_status" id="assigned-job-status">
                        <option value="">Select...</option>
                        <option value="1">Pending</option>
                        <option value="2">Ongoing</option>
                        <option value="3">Cancelled</option>
                        <option value="4">Completed</option>
                      </select>
                    </div>
                  </div>

                  <div class="col-md-4 paid d-none">
                    <div class="form-group position-relative">
                      <label>Paid <span class="text-danger">*</span></label>
                      <select class="form-control" name="paid" id="paid">
                        <option value="">Select...</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      </select>
                    </div>
                  </div>

                </div>

                <div class=" table-responsive">
                  <div id="amount-earned-sorting">
                    {{-- @include('admin.reports.cse.tables._amount_earned') --}}
                  </div>
                </div><!-- table-responsive -->
              </div><!-- card -->
            </div><!-- col -->
          </div><!-- row -->
        </div>

        <div id="technician_list" class="tab-pane pd-20 pd-xl-25">
            <div class="row row-xs">
              <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                  <div class="d-sm-flex mg-t-10"></div>

                  <div class="row mt-1 mb-1 ml-1 mr-1">
                    <div class="col-md-4">
                      <input type="hidden" class="d-none" id="route" value="{{ route('admin.technician_report_first_sorting', app()->getLocale()) }}">
                      <div class="form-group">
                        <label>Sorting Parameters</label>
                        <select class="custom-select" id="sorting-parameters">
                          <option value="" disabled selected>Select...</option>
                          <option value="SortType1">Teeeitory</option>
                          <option value="SortType2">Franchisee</option>
                          <option value="SortType3">On Boarding Date</option>
                          <option value="SortType4">CSE Status</option>
                          <option value="SortType5">Last Activity Date</option>
                          <option value="SortType6">Technician Rating</option>
                          <option value="SortType7">Job Assigned in last X Months</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 cse-list d-none">
                      <div class="form-group position-relative">
                        <label>{{ !empty($technicians->name) ? $technicians->name : 'TECHNICIAN' }} List <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" multiple id="cse-list">
                          <option value="" disabled>Select...</option>
                          @foreach ($technicians['users'] as $technician)
                          <option value="{{ $technician['account']['user_id'] }}">{{ !empty($technician['account']['first_name']) ? Str::title($technician['account']['first_name'] ." ". $technician['account']['last_name']) : 'UNAVAILABLE' }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4 date-range d-none">
                      <div class="form-group position-relative">
                        <label>From <span class="text-danger">*</span></label>
                        <input name="date_from" id="date-from" type="date" class="form-control pl-5">
                      </div>
                    </div>

                    <div class="col-md-4 date-range d-none">
                      <div class="form-group position-relative">
                        <label>To <span class="text-danger">*</span></label>
                        <input name="date_to" id="date-to" type="date" class="form-control pl-5" max="{{ Carbon\Carbon::now('UTC') }}">
                      </div>
                    </div>

                    <div class="col-md-4 job-status d-none">
                      <div class="form-group position-relative">
                        <label>Job Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="job_status" id="job-status">
                          <option value="">Select...</option>
                          <option value="1">Pending</option>
                          <option value="2">Ongoing</option>
                          <option value="3">Cancelled</option>
                          <option value="4">Completed</option>
                        </select>
                      </div>
                    </div>

                  </div>

                  <div class="table-responsive">
                    <div id="technician_list-sorting">
                      @include('admin.reports.technician.tables._technician_list')
                    </div>
                  </div><!-- table-responsive -->
                </div><!-- card -->
              </div><!-- col -->
            </div><!-- row -->
          </div>

          <div id="rating_history" class="tab-pane pd-20 pd-xl-25">
            <div class="row row-xs">
              <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                  <div class="d-sm-flex mg-t-10"></div>

                  <div class="row mt-1 mb-1 ml-1 mr-1">
                    <div class="col-md-4">
                      <input type="hidden" class="d-none" id="route" value="#">
                      <div class="form-group">
                        <label>Sorting Parameters</label>
                        <select class="custom-select" id="sorting-parameters">
                          <option value="" disabled selected>Select...</option>
                          <option value="SortType1">Name</option>
                          <option value="SortType2">Territory</option>
                          <option value="SortType3">Include Feedback</option>
                          <option value="SortType4">Technician Status</option>
                          <option value="SortType5">Ratings</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 cse-list d-none">
                      <div class="form-group position-relative">
                        <label>{{ !empty($technicians->name) ? $technicians->name : 'TECHNICIAN' }} List <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" multiple id="cse-list">
                          <option value="" disabled>Select...</option>
                          @foreach ($technicians['users'] as $technician)
                          <option value="{{ $technician['account']['user_id'] }}">{{ !empty($technician['account']['first_name']) ? Str::title($technician['account']['first_name'] ." ". $technician['account']['last_name']) : 'UNAVAILABLE' }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4 date-range d-none">
                      <div class="form-group position-relative">
                        <label>From <span class="text-danger">*</span></label>
                        <input name="date_from" id="date-from" type="date" class="form-control pl-5">
                      </div>
                    </div>

                    <div class="col-md-4 date-range d-none">
                      <div class="form-group position-relative">
                        <label>To <span class="text-danger">*</span></label>
                        <input name="date_to" id="date-to" type="date" class="form-control pl-5" max="{{ Carbon\Carbon::now('UTC') }}">
                      </div>
                    </div>

                    <div class="col-md-4 job-status d-none">
                      <div class="form-group position-relative">
                        <label>Job Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="job_status" id="job-status">
                          <option value="">Select...</option>
                          <option value="1">Pending</option>
                          <option value="2">Ongoing</option>
                          <option value="3">Cancelled</option>
                          <option value="4">Completed</option>
                        </select>
                      </div>
                    </div>

                  </div>

                  <div class="table-responsive">
                    <div id="_rating_history-sorting">
                      @include('admin.reports.technician.tables._rating_history')
                    </div>
                  </div><!-- table-responsive -->
                </div><!-- card -->
              </div><!-- col -->
            </div><!-- row -->
          </div>

          <div id="job_warranty_logs" class="tab-pane pd-20 pd-xl-25">
            <div class="row row-xs">
              <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                  <div class="d-sm-flex mg-t-10"></div>

                  <div class="row mt-1 mb-1 ml-1 mr-1">
                    <div class="col-md-4">
                      <input type="hidden" class="d-none" id="route" value="#">
                      <div class="form-group">
                        <label>Sorting Parameters</label>
                        <select class="custom-select" id="sorting-parameters">
                          <option value="" disabled selected>Select...</option>
                          <option value="SortType1">Technician Name</option>
                          <option value="SortType2">Job Category</option>
                          <option value="SortType3">Job ID</option>
                          <option value="SortType4">Job Description</option>
                          <option value="SortType5">Warranty Date Claim</option>
                          <option value="SortType6">Warranty Date Status</option>
                        </select>
                      </div>
                    </div>
                    <div class="col-md-4 cse-list d-none">
                      <div class="form-group position-relative">
                        <label>{{ !empty($technicians->name) ? $technicians->name : 'TECHNICIAN' }} List <span class="text-danger">*</span></label>
                        <select class="form-control selectpicker" multiple id="cse-list">
                          <option value="" disabled>Select...</option>
                          @foreach ($technicians['users'] as $technician)
                          <option value="{{ $technician['account']['user_id'] }}">{{ !empty($technician['account']['first_name']) ? Str::title($technician['account']['first_name'] ." ". $technician['account']['last_name']) : 'UNAVAILABLE' }}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="col-md-4 date-range d-none">
                      <div class="form-group position-relative">
                        <label>From <span class="text-danger">*</span></label>
                        <input name="date_from" id="date-from" type="date" class="form-control pl-5">
                      </div>
                    </div>

                    <div class="col-md-4 date-range d-none">
                      <div class="form-group position-relative">
                        <label>To <span class="text-danger">*</span></label>
                        <input name="date_to" id="date-to" type="date" class="form-control pl-5" max="{{ Carbon\Carbon::now('UTC') }}">
                      </div>
                    </div>

                    <div class="col-md-4 job-status d-none">
                      <div class="form-group position-relative">
                        <label>Job Status <span class="text-danger">*</span></label>
                        <select class="form-control" name="job_status" id="job-status">
                          <option value="">Select...</option>
                          <option value="1">Pending</option>
                          <option value="2">Ongoing</option>
                          <option value="3">Cancelled</option>
                          <option value="4">Completed</option>
                        </select>
                      </div>
                    </div>

                  </div>

                  <div class="table-responsive">
                    <div id="job_warranty_logs">
                      @include('admin.reports.technician.tables._job_warranty_logs')
                    </div>
                  </div><!-- table-responsive -->
                </div><!-- card -->
              </div><!-- col -->
            </div><!-- row -->
          </div>
      </div>
    </div>
  </div>
</div>




@push('scripts')
<script src="{{ asset('assets/dashboard/assets/js/bootstrap-multiselect.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/admin/reports/technician/job_assigned_filter.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/admin/reports/technician/amount_earned_filter.js') }}"></script>
<script>
  $(document).ready(function(){
    $('.selectpicker').selectpicker(); //Initiate multiple dropdown select
  });
</script>

@endpush

@endsection
