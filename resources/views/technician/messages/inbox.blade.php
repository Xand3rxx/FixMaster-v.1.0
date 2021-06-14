@extends('layouts.dashboard')
@section('title', 'Messages')
@include('layouts.partials._messages')
@section('content')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.mail.css') }}">

@include('layouts.partials._quality_message_composer')
<div class="mail-wrapper ml-2">
  <div class="mail-sidebar">
    <div class="mail-sidebar-body">
    </div>
  </div>

  <div class="mail-group">
    <div class="mail-group-header">

      <div class="pd-10">
        <a href="#technicianMessageComposer" data-toggle="modal" class="btn btn-primary btn-block tx-uppercase tx-10 tx-medium tx-sans tx-spacing-4">Compose</a>
      </div>

      
    </div><!-- mail-group-header -->
    <div class="mail-group-body">
      <div class="pd-y-15 pd-x-20 d-flex justify-content-between align-items-center">
        <h6 class="tx-uppercase tx-semibold mg-b-0">Inbox</h6>
        {{-- <div class="dropdown tx-13">
         
        </div> --}}
      </div>
    
      <label class="mail-group-label"></label>
        <ul class="list-unstyled media-list mg-b-0">         
          {{-- <li class="media"> --}}
                                 
                {{-- <div class="avatar"><img src="{{ asset('assets/images/default-male-avatar.png') }}" alt="Default male profile avatar" class="rounded-circle shadow d-block mx-auto" /></div>
                
                <div class="avatar"><img src="" class="rounded-circle" alt="" /></div> --}}
                 
            {{-- <div class="avatar"><img src="../https://via.placeholder.com/350" class="rounded-circle" alt=""></div> --}}
            <div class="media-body mg-l-15">
              {{-- <div class="tx-color-03 d-flex align-items-center justify-content-between mg-b-2">
                <span class="tx-12">My Name</span>
                <span class="tx-11">Current Time</span>
              </div> --}}
              {{-- <h6 class="tx-13">{{ 'Report' }}</h6>
              <p class="tx-12 tx-color-03 mg-b-0"></p> --}}
            </div><!-- media-body -->
          {{-- </li> --}}
         
        </ul>
     
    </div><!-- mail-group-body -->
  </div><!-- mail-group -->

  <div class="mail-content" id="mail-content">
    <!-- Message body displays here -->
    <div id="spinner-icon"></div>
  </div><!-- mail-content -->
</div><!-- mail-wrapper -->

{{-- @include('admin.messages._admin_message_composer') --}}

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

              if(window.matchMedia('(max-width: 1199px)').matches) {
                $('body').addClass('mail-content-show');
              }

              if(window.matchMedia('(min-width: 768px)').matches) {
                $('#mailSidebar').removeClass('d-md-none');
                $('#mainMenuOpen').removeClass('d-md-flex');
              }
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


    $('#Send-Message').click(function(){
            
            var subject = $('#subject').val();
            var recipients = $('#users').val();
      
            var content = $('#messageBody').val();
            var sender = '<?php echo Auth::user()->id; ?>';

            var url = window.location.origin;

            if(!subject){
              Swal.fire( '', 'Please enter message subject!', 'error' )
              return false;
            }

            if(recipients.length===0 && $('#recipient_id').val()!=4){
              Swal.fire( '', 'Please select recipient!', 'error' )
              return false;
            }else if($('#recipient_id').val()===4){
              recipients = $('#recipient_id').val();
            }

            if(!content){
              Swal.fire( '', 'Please enter message!', 'error' )
              return false;
            }
              Swal.showLoading();
              let receivers = [];
              let receiver = {};
              $.each(recipients, function(ind, val){
                  receiver = {
                    "id":ind,
                    "value":val
                  }
                receivers.push(receiver);
              });
            var jqxhr = $.post(url+"/api/messaging/save_email",
            {
               subject:subject,
               recipients:receivers,
               mail_content:content,
               sender:sender
            },
            function(data, status){
                //TODO change display message to sweet alert
                Swal.close();
                console.log(data);
                displayMessage(data.message, 'success');
            })
            .fail(function(data, status) {
                displayMessage(data.responseJSON.message, 'error');
            })
            


          

         });


    //Get list of users by a particular designation
    $('#user-type').on('change',function () {
        let user = $(this).find('option:selected').val();
        let route = $(this).find('option:selected').data('url');

        $.ajaxSetup({
            headers: {
                'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: route,
            beforeSend: function() {
                $("#spinner-icon-admin").html('<div class="d-flex justify-content-center mt-4 mb-4" style="margin-left: 40px !important"><span class="loadingspinner"></span></div>');
            },
            // return the result
            success: function(result) {

                // $('.admin-list').removeClass('d-none');
                $('#admin-list').html('');
                $('#admin-list').html(result);
            },
            complete: function() {
                $("#spinner-icon").hide();
            },
            error: function(jqXHR, testStatus, error) {
                var message = error+ ' occured while trying to retireve '+ user +' list.';
                var type = 'error';
                displayMessage(message, type);
                $("#spinner-icon-admin").hide();
            },
            timeout: 8000
        })  
    });

    //Get list of users by a particular service request reference
    $('#ongoing_requests').on('change',function () {
        let user = $(this).find('option:selected').val();
        let route = $(this).find('option:selected').data('url');

        $.ajaxSetup({
            headers: {
                'X-CSRF_TOKEN':$('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: route,
            beforeSend: function() {
                $("#spinner-icon-admin").html('<div class="d-flex justify-content-center mt-4 mb-4" style="margin-left: 40px !important"><span class="loadingspinner"></span></div>');
            },
            // return the result
            success: function(result) {

                // $('.admin-list').removeClass('d-none');
                $('#admin-list').html('');
                $('#admin-list').html(result);
            },
            complete: function() {
                $("#spinner-icon").hide();
            },
            error: function(jqXHR, testStatus, error) {
                var message = error+ ' occured while trying to retireve '+ user +' list.';
                var type = 'error';
                displayMessage(message, type);
                $("#spinner-icon-admin").hide();
            },
            timeout: 8000
        })  
    });


  });
  //call the api for getting ongoing job requests made to the technician
function ongoingJobsEvent(currentValue){

//  when ongoing jobs option is selected, the 'hidden' attribute of the 'div' is falsified
//  and the select element toggles to be visible 
 
if(currentValue === "jobs"){
  document.getElementById("ongoingJobs").hidden = false;
  document.getElementById("assoc_users").hidden = false;
  
  var options="";
  var cnt = 0;
  var url = window.location.origin;
  var technicianid = document.getElementById("currentuser").value;
        $.get( url+"/api/requests/ongoing_jobs_technician?userid="+technicianid, function( data ) {
            $.each(data.data, function(key, val){
            cnt++;
            if(cnt===1){
                getInvolvedUsers(val.unique_id, technicianid)
              }
            options ='<option value = "'+val.unique_id+'">'+val.unique_id+'</option>';
            $('#jobsId').append(options);
  })
});

} else if(currentValue != "jobs"){
  document.getElementById("ongoingJobs").hidden = true;
  document.getElementById("assoc_users").hidden = true;
}
}

//call the api for getting users involved with the requests made to technicians(**returns an empty array**)
function getInvolvedUsers(currentValue, technicianid){
    var options="";
    var cnt;
    var url = window.location.origin;
    $.get( url+"/api/requests/involved_users?reqid="+currentValue+"&userid="+technicianid, function( data ) {

              $('#users').empty()
              $.each(data.data, function(key, val){
              cnt++;
              options ='<option value="'+val.user_id+'">'+val.first_name+' ' +val.last_name+'</option>';
              $('#users').append(options);
    })
    })
}
</script>

@endpush
@endsection
