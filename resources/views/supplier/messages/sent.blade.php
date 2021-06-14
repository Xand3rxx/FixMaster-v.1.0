@extends('layouts.dashboard')
@section('title', 'Messages')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.mail.css') }}">
@include('layouts.partials._quality_message_composer')

<div class="mail-wrapper ml-2">
  <div class="mail-sidebar">
    <div class="mail-sidebar-body">
    </div><!-- mail-sidebar-body -->
  </div><!-- mail-sidebar -->

  <div class="mail-group">
    <div class="mail-group-header">
     
      <div class="pd-10">
        <a href="#technicianMessageComposer" data-toggle="modal" class="btn btn-primary btn-block tx-uppercase tx-10 tx-medium tx-sans tx-spacing-4">Compose</a>
      </div>

    </div><!-- mail-group-header -->
    <div class="mail-group-body">
      <div class="pd-y-15 pd-x-20 d-flex justify-content-between align-items-center">
        <h6 class="tx-uppercase tx-semibold mg-b-0">Outbox</h6>
        <div class="dropdown tx-13">
        </div>
      </div>
      
      <label class="mail-group-label"></label>
        <ul class="list-unstyled media-list mg-b-0">
          
          <li class="media" data-url="">

        <div class="avatar"></div>
               
            <div class="media-body mg-l-15">
              <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12"></span>
                <span class="tx-11"></span>
              </div>
              <h6 class="tx-13"></h6>
              <p class="tx-12 tx-color-03 mg-b-0"></p>
            </div><!-- media-body -->
          </li>
        </ul>
     
    </div><!-- mail-group-body -->
  </div><!-- mail-group -->

  <div class="mail-content"> {{--id="mail-content"--}}
    <!-- Message body displays here -->
    <div id="spinner-icon"></div>
  </div><!-- mail-content -->
</div><!-- mail-wrapper -->

  @push('scripts')

  <script src="{{ asset('assets/dashboard/assets/js/dashforge.mail.js') }}"></script>

  <script>
    $(document).ready(function (){
      $(document).on('click', '.mail-group-body .media', function(){
        // e.preventDefault();
        let route = $(this).attr('data-url');

        $.ajax({
            url: route,
            beforeSend: function() {
              $("#spinner-icon").html('<div class="d-flex justify-content-center mt-4 mb-4" style="margin-top: 200px !important"><span class="loadingspinner"></span></div>');
            },
            // return the result
            success: function(result) {
                $('#mail-content').html('');
                $('#mail-content').html(result);
                $('.mail-content-header, .mail-content-body').removeClass('d-none');
            },
            complete: function() {
                $("#spinner-icon").hide();
            },
            error: function(jqXHR, testStatus, error) {
                var message = error+ ' occured while trying to retireve message details.';
                var type = 'error';
                displayMessage(message, type);
                $("#spinner-icon").hide();
            },
            timeout: 8000
        });

      });
    });
  </script>

  @endpush
@endsection