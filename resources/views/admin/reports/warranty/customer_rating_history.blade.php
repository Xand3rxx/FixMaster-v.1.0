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
   

        <div id="extended_warranty_claim_list" class="tab-pane show active pd-20 pd-xl-25">
          <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
              <div class="card mg-b-10">
                <div class="d-sm-flex mg-t-10"></div>

                <div class="row mt-1 mb-1 ml-1 mr-1">
                  <div class="col-md-4">
                  <input type="hidden" class="d-none" id="route" value="{{ route('admin.customer_rating_history_list_report_sorting', app()->getLocale()) }}">

                    <div class="form-group">
                      <label>Sorting Parameters</label>
                      <select class="custom-select" id="sorting-parameters">
                        <option value="" disabled selected>Select...</option>
                        <option value="SortType10">Customer ID</option>
                        <option value="SortType1">Customer Name</option>
                        <option value="SortType6">Territory</option>
                        <option value="SortType11">Include Feed Back</option>
                        <option value="SortType9">Customer Status</option>
                        <option value="SortType12">Rating</option>
                      
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

                  <div class="col-md-4 warranty-ids d-none">
                    <div class="form-group position-relative">
                      <label>{{ !empty($customers) ? 'Customer ID' : "Waranty's" }} List <span class="text-danger">*</span></label>
                      <select class="form-control selectpicker" multiple id="warranty-ids">
                        <option value="" disabled>Select...</option>
                        @if( !empty($customers) )
                        @foreach ($customers as $warranty)
                        <option value="{{ $warranty['user']['id'] }}">
                        {{ $warranty['user']['id'] }}</option>
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

                 
                 
                    

          
                  <div class="col-md-4 customer-status d-none">
                    <div class="form-group position-relative">
                      <label>Customer Status <span class="text-danger">*</span></label>
                      <select class="form-control" name="customer_status" id="customer_status">
                        <option value="">Select...</option>
                        <option value="yes">Active</option>
                        <option value="no">Inactive</option>
                      
                      </select>
                    </div>
                  </div>

            
                <div class="col-md-4 customer-rating d-none">
                    <div class="form-group position-relative">
                      <label>Customer Rating <span class="text-danger">*</span></label>
                      <select class="form-control" name="customer_rating" id="customer_rating">
                        <option value="">Select...</option>
                        <option value="yes">Summary</option>
                        <option value="no">Detaill</option>
                      
                      </select>
                    </div>
                  </div>

            

                <div class="col-md-4 customer-feedback d-none">
                    <div class="form-group position-relative">
                      <label>Customer FeedBack <span class="text-danger">*</span></label>
                      <select class="form-control" name="customer_feedback" id="customer_feedback">
                      <option value="">Select...</option>
                        <option value="yes">Yes</option>
                        <option value="no">No</option>
                      
                      </select>
                    </div>
                  </div>

                </div>

                <div class="table-responsive">
                  <div id="job-assigned-sorting">
                    @include('admin.reports.warranty.tables._customer_rating')
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
]<script src="{{ asset('assets/dashboard/assets/js/admin/reports/warranty/extended_warranty.js') }}"></script>
<script src="{{ asset('assets/dashboard/assets/js/admin/discount/4c676ab8-78c9-4a00-8466-a10220785894.js') }}"></script>

<script>
  $(document).ready(function(){
    $('.selectpicker').selectpicker(); //Initiate multiple dropdown select
  });
</script>

@endpush

@endsection
