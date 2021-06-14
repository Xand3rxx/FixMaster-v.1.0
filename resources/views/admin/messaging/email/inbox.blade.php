@extends('layouts.dashboard')
@section('title', 'Inbox')
@section('content')
@include('layouts.partials._messages')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/dashforge.mail.css') }}">

<div class="mail-wrapper ml-2">
  <div class="mail-sidebar">
    <div class="mail-sidebar-body">
    </div>
  </div>

  <div class="mail-group">
    <div class="mail-group-header">

      <div class="pd-10">
        <a href="{{ route('admin.new_email', app()->getLocale()) }}"  class="btn btn-primary btn-block tx-uppercase tx-10 tx-medium tx-sans tx-spacing-4">Compose</a>
      </div>

      
    </div><!-- mail-group-header -->
    <div class="mail-group-body">
        <div class="pd-y-15 pd-x-20 d-flex justify-content-between align-items-center">
          <h6 class="tx-uppercase tx-semibold mg-b-0">Inbox</h6>
          <div class="dropdown tx-13">
            <span class="tx-color-03">Sort:</span> <a href="" class="dropdown-link link-02">Date</a>
          </div><!-- dropdown -->
        </div>
    
        
      </div><!-- mail-group-body -->
  </div><!-- mail-group -->

  <div class="mail-content">
    <div class="mail-content-header">
        <div class="media">
        <div class="avatar avatar-sm"><img src="https://via.placeholder.com/600" class="rounded-circle" alt=""></div>
        <div class="media-body mg-l-10">
            <h6 class="mg-b-2 tx-13" id="sender-name"></h6>
            <span class="d-block tx-11 tx-color-03" id="message-time"></span>
        </div><!-- media-body -->
        </div><!-- media -->
    </div><!-- mail-content-header -->
    <div class="mail-content-body">
        
        <div class="pd-20 pd-lg-25 pd-xl-30">
        <h5 class="mg-b-30"></h5>
        </div>
        <div class="pd-20 pd-lg-25 pd-xl-30" id="mail-content-body">
        </div>
    </div><!-- mail-content-body -->
</div><!-- mail-wrapper -->


@push('scripts')
  <script src="{{ asset('assets/dashboard/assets/js/dashforge.mail.js') }}"></script>

  <script>
    $(document).ready(function (){
      //Onclick to view message
      $(document).on('click', '.mail-group-body .media', function(){
        
        var url = window.location.origin
        
        var mailid = $(this).attr('data-id')
        $.ajax({
            url: url+`/api/messaging/getMessage/?message_id=${mailid}`,
            beforeSend: function() {
              $("#mail-content-body").html('<div class="d-flex justify-content-center mt-4 mb-4" style="margin-top: 200px !important"><span class="loadingspinner"></span></div>');
            },
            // return the result
            success: function(result) {
                 var val = result.data;
                 var mail_date = new Date(val.created_at);
                 var today = new Date();
                 var hour = mail_date.getHours()
                 var period = (hour>=12)?'PM':'AM';
                 var message_time = `${hour}:${mail_date.getMinutes()} ${period}`
                 var day2 = today.getDate();
                 var day1 = mail_date.getDate();
                 var dateDiff = day2 - day1;
                 var labelText = ""; 
                  

                 
                    if(dateDiff==0){
                      labelText = "Today";
                    }else if(dateDiff==1){
                      labelText = "Yesterday";
                    }else if(dateDiff>1){ 
                      labelText =`${getMonthName(mail_date.getMonth())} ${mail_date.getDate()}`;
                    }
                $('#mail-content-body').html('');
                $('#sender-name').html(`${val.first_name} ${val.last_name}`);
                $('#message-time').html(`${labelText}, ${message_time}`);
                $('.mg-b-30').html(`${val.title}`);
                $('#mail-content-body').html(`${val.content}`);
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
                $("#mail-content").hide();
            },
            error: function(jqXHR, testStatus, error) {
                var message = error+ ' occured while trying to retireve message details.';
                var type = 'error';
                displayMessage(message, type);
                $("#mail-content").hide();
            },
            timeout: 8000
        });

      });


    });
  </script>
@endpush

  

@section('scripts')
@endsection
<script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script>
<script>
    var url = window.location.origin
        $(document).ready(function() {
            var trow="";
            var cnt = 0;
            $.get(  url+'/api/messaging/inbox/?userid={{Auth::user()->id}}', function( data ) {
              buildMailListComponent(data); 
            });
        });
    function buildMailListComponent(data)
    {
      var content = "";
      var labelText = "";
      var ulElm = "";
      var liElm = "";
      var divElm = "";
      var divElm2 = "";
      var pElm = "";
      var hElm = "";
      var initialDate = new Date();
      var today = initialDate;
      var mail_date = "";
      var day1, day2;
      var dateDiff = 0;
      var message_time = "";
      var dateChanged = true;
      var hour = 0;
      var period = "";
      var first_letter = "";
      var status_class = "";
      var counts = 0, msg_count=0;
      var avatar_colors = ['bg-indigo', 'bg-gray-800', 'bg-pink', 'bg-teal', 
      'bg-primary', 'bg-purple'];


      $.each(data.data, function(key, val){
        mail_date = new Date(val.created_at);
        hour = mail_date.getHours()
        period = (hour>=12)?'PM':'AM';
        message_time = `${hour}:${mail_date.getMinutes()} ${period}`
        day2 = today.getDate();
        day1 = mail_date.getDate();
        dateDiff = day2 - day1;
        if(initialDate.getDate()!=day1)
          dateChanged = true;
        
        

        if(dateChanged==true){
          if(dateDiff==0){
            labelText = "Today";
          }else if(dateDiff==1){
            labelText = "Yesterday";
          }else if(dateDiff>1){ 
            labelText =`${getMonthName(mail_date.getMonth())} ${mail_date.getDate()}`;
          }

          if(msg_count==0){
          $('#sender-name').html(`${val.first_name} ${val.last_name}`);
          $('#message-time').html(`${labelText}, ${message_time}`);
          $('.mg-b-30').html(`${val.title}`);
          $('#mail-content-body').html(`${val.content}`);
          
          
        }
          $( "<label/>", {
              "class": "mail-group-label",
              text: `${labelText}`
            }).appendTo( ".mail-group-body" );
       
          ulElm = $( "<ul />", {
              "class": "list-unstyled media-list mg-b-0"
            });
            ulElm.appendTo( ".mail-group-body" );
          initialDate = mail_date
          dateChanged = false
        }
     
        first_letter = val.first_name.substr(0,1);
        if(val.mail_status=="pending")
           status_class="unread";
        else
            status_class = "";
      
        liElm = $("<li />", {"class":`media ${status_class}`, "data-id":`${val.uuid}`});
        divElm = $("<div />", {"class":"avatar"})
        spanElm = $("<span />",{"class":`avatar-initial rounded-circle ${avatar_colors[counts]}`});
        spanElm.html(first_letter)
        divElm.append(spanElm)
        liElm.append(divElm)
        divElm = $("<div />", {"class":"media-body mg-l-15"})
        divElm2 = $("<div />", {"class":"tx-color-03 d-flex align-items-center justify-content-between mg-b-2"})
        spanElm = $("<span />",{"class":"tx-12"});
        spanElm.html(`${val.first_name} ${val.last_name}`)
        divElm2.append(spanElm)
        spanElm = $("<span />",{"class":"tx-11"});
        spanElm.html(`${message_time}`)
        divElm2.append(spanElm)
        divElm.append(divElm2)
        hElm = $("<h6 />",{"class":"tx-13"});
        hElm.html(`${val.title}`)
        divElm.append(hElm)
        pElm = $("<p />", {"class":"tx-12 tx-color-03 mg-b-0"});
        pElm.html(`${val.content.substr(0,100)} ...`)
        divElm.append(pElm)  
        liElm.append(divElm)
        ulElm.append(liElm)
        counts++;
        if(counts > avatar_colors.length)
        counts=0;
        msg_count++;
      });
      
  }
function diffDays(date1, date2)
{
  const diffTime = Math.abs(date2 - date1);
  const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)); 
  return diffDays;  
}

function getMonthName(month)
{
  var months = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
  return months[month];
}
    </script>
@endsection
