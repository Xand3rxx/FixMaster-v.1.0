@extends('layouts.dashboard')
@section('title', 'Service Request Settings')
@include('layouts.partials._messages')
@section('content')
<div class="content-body">
    <div class="container pd-x-0">
      <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
        <div>
          <nav aria-label="breadcrumb">
            <ol class="breadcrumb breadcrumb-style1 mg-b-10">
              <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
              <li class="breadcrumb-item active" aria-current="page">Service Request Settings</li>
            </ol>
          </nav>
          <h4 class="mg-b-0 tx-spacing--1">Service Request Settings</h4>
        </div>
      </div>

      <input type="hidden" id="path_admin" value="{{url('/')}}">

      <div class="row row-xs">
       
        <div class="col-lg-12 col-xl-12 mg-t-10">
            <div class="card mg-b-10">
              <!-- card-header -->
             
              <div class="table-responsive">
                
              <div id="sort_table">
                  @include('admin.settings._service-req-criteria')
                </div>

              </div><!-- table-responsive -->
            </div><!-- card -->
    
          </div><!-- col -->

      </div>

    </div>
</div>

   <!-- Modal with form -->
<div class="modal fade" id="editCriteria" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true" data-keyboard="false" data-backdrop="static">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="formModal">Edit Criteria</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="modal-body">
          
      </div>
    </div>
  </div>
</div>

  
@push('scripts')
<script>

$(document).on('click', '#criteria-edit', function(event) {
        event.preventDefault();
        let route = $(this).attr('data-url');
        
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
                var message = error+ ' An error occured while trying to retireve service request settings.';
                var type = 'error';
                displayMessage(message, type);
                $("#spinner-icon").hide();
            },
            timeout: 8000
        })
    });
  
</script>
@endpush

@endsection