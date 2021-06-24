@extends('layouts.dashboard')
@section('title', 'Warranty Reports')
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
            <li class="breadcrumb-item active" aria-current="page">Warranty</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Warranty Reports</h4>
      </div>
    </div>

    <div class="contact-content-header mt-4">
    @include('admin.reports.warranty.nav')

    </div><!-- contact-content-header -->

    <div class="contact-content-body">
      <div class="tab-content">
        <div id="warranty_claim_list" class="tab-pane show active pd-20 pd-xl-25">
          <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
              <div class="card mg-b-10">
                <div class="d-sm-flex mg-t-10"></div>

                <div class="row mt-1 mb-1 ml-1 mr-1">
                  <div class="col-md-4">
                    <input type="hidden" class="d-none" id="route" value="{{ route('admin.warranty_list_report_sorting', app()->getLocale()) }}">
                    <div class="form-group">
                      <label>Sorting Parameters</label>
                      <select class="custom-select" id="sorting-parameters">
                        <option value="" disabled selected>Select...</option>
                        <option value="SortType1">Customer ID</option>
                        <option value="SortType5">Job ID</option>
                        <option value="SortType6">Territory</option>
                        <option value="SortType7">Job category</option>
                        <!-- <option value="SortType2">Job Acceptance Date</option>
                        <option value="SortType3">Job Completion Date</option>-->
                        <option value="SortType4">Warranty claims </option> 
                      </select>
                    </div>
                  </div>
                  <div class="col-md-4 warranty-id-list d-none">
                    <div class="form-group position-relative">
                      <label>{{ !empty($customers) ? 'Customer ID' : "Waranty's" }} List <span class="text-danger">*</span></label>
                      <select class="form-control selectpicker" multiple id="warranty-id-list">
                        <option value="" disabled>Select...</option>
                        @if( !empty($customers) )
                        @foreach ($customers as $warranty)
                        <option value="{{ $warranty['user']['id'] }}">
                        {{ $warranty['account']['first_name'].' '.$warranty['account']['last_name'] }}</option>
                        @endforeach
                        @endif

                      </select>
                    </div>
                  </div>

                  <div class="col-md-4 service-id-list d-none">
                    <div class="form-group position-relative">
                      <label>{{ !empty($customers) ? 'Job ID' : "Job's" }} List <span class="text-danger">*</span></label>
                      <select class="form-control selectpicker" multiple id="service-id-list">
                        <option value="" disabled>Select...</option>
                        @if( !empty($customers) )
                        @foreach ($customers as $item)
                        @foreach ($item['service_requests'] as $warranty)
                        <option value="{{ $warranty['unique_id'] }}">
                        {{ $warranty['unique_id']?? 'UNAVAILABLE' }}</option>
                        @endforeach
                        @endforeach
                        @endif
                      </select>
                    </div>
                  </div>


                  <div class="form-group col-md-4 lga-list d-none">
                                    <label for="entity">States</label>
                                    <select id="state_id" name="specified_request_state" class="custom-select cs-select get_users">
                                        <option selected value="">Select...</option>
                                        @foreach($states as $state)
                                        <option value="{{ $state->id }}"
                                            {{ old('state') == $state->id ? 'selected' : ''}}>
                                            {{ $state->name }}</option>
                                        @endforeach
                                    </select>

                                </div>

                                <div class="col-md-4 lga-list d-none">
                                <div class="form-group position-relative">
                                    <label>LGAs</label>
                                    <select class="form-control selectpicker cs-select" multiple  name="specified_request_lga" id="lga_list">
                                    <option value="" disabled>Select...</option>
                                    </select>
                                </div>
                            </div>

                            <input type="hidden"  data-lga="{{ route('admin.getLGA',app()->getLocale()) }}" id="get_lga_url" />

                 
                 
                    <div class="col-md-4 category-list d-none">
                    <div class="form-group position-relative">
                      <label>{{ !empty($category) ? 'Category ID' : "Category's" }} List <span class="text-danger">*</span></label>
                      <select class="form-control selectpicker" multiple id="category-list">
                        <option value="" disabled>Select...</option>
                        @if( !empty($category) )
                        @foreach ($category as $warranty)
                        <option value="{{ $warranty['id'] }}">
                        {{ $warranty['name'] }}</option>
                        @endforeach
                        @endif

                      </select>
                    </div>
                  </div> 

          
                  
                  <!-- <div class="col-md-4 date-range d-none">
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
                  </div> -->

                  <div class="col-md-4 job-claims d-none">
                    <div class="form-group position-relative">
                      <label>Warranty claims <span class="text-danger">*</span></label>
                      <select class="form-control" name="job_status" id="job-claims">
                        <option value="">Select...</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                      
                      </select>
                    </div>
                  </div>

                </div>

                <div class="table-responsive">
                  <div id="job-assigned-sorting">
                    @include('admin.reports.warranty.tables._warranty_claims_list')
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
<script src="{{ asset('assets/dashboard/assets/js/admin/reports/warranty/list_filter.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/admin/discount/4c676ab8-78c9-4a00-8466-a10220785894.js') }}"></script>

<script>
  $(document).ready(function(){
    $('.selectpicker').selectpicker(); //Initiate multiple dropdown select
  });
</script>

@endpush

@endsection
