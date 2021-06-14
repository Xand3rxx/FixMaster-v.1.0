@extends('layouts.dashboard')
@section('title', 'Tools Request')
@include('layouts.partials._messages')
@section('content')

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div>
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
            <li class="breadcrumb-item active" aria-current="page">Tools Request</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Tools Request</h4>
      </div>
    </div>

    <div class="row row-xs">
      <div class="col-lg-12 col-xl-12 mg-t-10">
        <div class="card mg-b-10">
          <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
            <div>
              <h6 class="mg-b-5">Tools requested as of {{ date('M, d Y') }}</h6>
              <p class="tx-13 tx-color-03 mg-b-0">This table displays a list of all FixMaster Tools requested for a job.</p>
            </div>
            
          </div><!-- card-header -->
         
          <div class="table-responsive">
            
            <table class="table table-hover mg-b-0" id="basicExample">
              <thead class="thead-primary">
                <tr>
                  <th class="text-center">#</th>
                  <th>Job Ref.</th>
                  <th>Batch Number</th>
                  <th>Client</th>
                  <th>Approved By</th>
                  <th>Requested By</th>
                  <th>Status</th>
                  <th>Date Requested</th>
                  <th>Action</th>
                </tr>
              </thead>
              <tbody>
                @foreach ($toolRequests as $toolRequest)
                  <tr>
                    <td class="tx-color-03 tx-center">{{ ++$i }}</td>
                    <td class="tx-medium">{{ $toolRequest->serviceRequest->unique_id }}</td>
                    <td class="tx-medium">{{ $toolRequest->unique_id }}</td>
                    <td class="tx-medium">{{ Str::title($toolRequest['serviceRequest']['client']['first_name'] ." ". $toolRequest['serviceRequest']['client']['last_name']) }}</td>
                    <td class="tx-medium">{{ Str::title($toolRequest['approver']['account']['first_name'] ." ". $toolRequest['approver']['account']['last_name']) }}</td>
                    <td class="tx-medium">{{ Str::title($toolRequest['requester']['account']['first_name'] ." ". $toolRequest['requester']['account']['last_name']) }}</td>
                    @if($toolRequest->status == 'Pending')
                      <td class="text-medium text-warning">Pending</td>
                    @elseif($toolRequest->status == 'Approved')
                      <td class="text-medium text-success">Approved</td>
                    @else
                      <td class="text-medium text-danger">Declined</td>
                    @endif
                    <td class="text-medium">{{ Carbon\Carbon::parse($toolRequest->created_at, 'UTC')->isoFormat('MMMM Do YYYY, h:mm:ssa') }}</td>
                    <td class=" text-center">
                      <div class="dropdown-file">
                        <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                        <div class="dropdown-menu dropdown-menu-right">
                        <a href="#toolsRequestDetails" data-toggle="modal" class="dropdown-item details text-primary" title="View {{ $toolRequest->unique_id}} details" data-batch-number="{{ $toolRequest->batch_number}}" data-url="{{ route('admin.tool_request_details', ['tool_request'=>$toolRequest->uuid, 'locale'=>app()->getLocale()]) }}" id="tool-request-details"><i class="far fa-clipboard"></i> Details</a>
                        @if($toolRequest->status == 'Pending')
                          <a href="{{ route('admin.approve_tool_request', ['tool_request'=>$toolRequest->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success"><i class="fas fa-check"></i> Approve</a>
                          <a href="{{ route('admin.decline_tool_request', ['tool_request'=>$toolRequest->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-danger"><i class="fas fa-ban"></i> Decline</a>
                        @endif
                        @if($toolRequest->status == 'Approved' && $toolRequest->is_returned == '0')
                          <a href="{{ route('admin.return_tools_requested', ['tool_request'=>$toolRequest->uuid, 'locale'=>app()->getLocale()]) }}" class="dropdown-item details text-success"><i class="fas fa-undo"></i> Mark as Returned</a>
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

  <div class="modal fade" id="toolsRequestDetails" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true" data-keyboard="false" data-backdrop="static">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content tx-14">
        <div class="modal-header">
          <h6 class="modal-title" id="exampleModalLabel2">Tools Request</h6>
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


@push('scripts')
<script>
  $(document).ready(function() {
    $(document).on('click', '#tool-request-details', function(event) {
      event.preventDefault();
      let route = $(this).attr('data-url');
      let batchNumber = $(this).attr('data-batch-number');
      
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
              var message = error+ ' An error occured while trying to retireve '+ batchNumber +'  details.';
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
@endpush

@endsection