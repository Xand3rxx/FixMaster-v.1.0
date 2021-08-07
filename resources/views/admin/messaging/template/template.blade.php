@extends('layouts.dashboard')
@section('title', 'Notification List')
@include('layouts.partials._messages')
@section('content')
<style>
 .btn-placeholder{
   margin-bottom:5px;
 }
</style>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
{{-- <script src="{{ asset('assets/dashboard/lib/jquery/jquery.min.js') }}"></script> --}}
{{-- <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script> --}}
{{-- <script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}

<!-- include summernote css/js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" defer></script>

 <script>
var url = window.location.origin;
var editor_disabled = false;
var checked_value = 'Email';
$(document).ready(function () {
    $.get( url+"/api/template/list", function( data ) {
        var trow = "";
        var cnt =0;
        $.each(data.data, function(key, val){
          cnt++;
           trow = '<tr data-id="'+val.uuid+'">';
           trow += '<td class="tx-color-03 tx-center">'+cnt+'</td>';
           trow += '<td class="tx-medium">'+ val.title + '</td>'
           trow += '<td class="tx-medium">'+val.feature+'</td>';
           trow += '<td class="text-medium nav-item"><span>';
           trow += '<a href="templates/new/?templateid='+val.uuid+'" class="msgedit" style="float: left;margin-right:10px;">';
        //    trow += '<i data-feather="edit" style="font-size: 9px;"></i></a></span>';
           trow += '<img src="'+ url+'/assets/images/icon/edit.svg" alt="Image"/></a></span>';
           trow += '<span>  <a href="#" class="msgdelete" style="float: left; margin-right:10px;">';
           trow += '<img src="'+ url+'/assets/images/icon/trash.svg" alt="Image"/></a></span></td>';
          // trow += '<i data-feather="trash" style="font-size: 9px;"></i></a></span></td>';
           trow += '</tr>';
             $('#template-list').append(trow);
        })
      });
       $("#btn-save").show();
        $("#btn-update").hide();
        $("#email_editor").summernote({
        height: 150
    });
        $("#btnNewTemplate").click(function(){
            $('#email-title').val("")
            $('#email_editor'). summernote('code', '')
            $("#btn-save").show();
            $("#btn-update").hide();
            $("#messageModal").modal('show');
        })
    $('i.note-recent-color').each(function(){
        $(this).attr('style','background-color: transparent;');
    });
    $('.btn-placeholder').click(function(){
        var toInsert = '{'+$(this).data('val')+'}';
        if(editor_disabled==true){
            insertTextArea('email_editor',toInsert)
        }else if(editor_disabled==false){
        var selection = document.getSelection();
        var cursorPos = selection.anchorOffset;
        var oldContent = selection.anchorNode.nodeValue;
        var newContent = oldContent.substring(0, cursorPos) + toInsert + oldContent.substring(cursorPos);
        selection.anchorNode.nodeValue = newContent;
        }
    });
    $('#btn-save').click(function(){
        updateMessageTemplate('save');
    });
     $('#btn-update').click(function(){
        updateMessageTemplate('update');
    });
    $('#rd-email').click(function(){
        editor_disabled = false;
        checked_value = 'Email';
       $('#email_editor').summernote({height: 150});
    });
    $('#rd-sms').click(function(){
       editor_disabled = true;
       checked_value = 'SMS';
       $('#email_editor').summernote('destroy');
    });
    $.get( url+"/api/template/features", function( data ) {
        $.each(data, function(key, val){
             $('<option>').val(val).text(val).appendTo('#feature');
        })
      });
    // $(document).on('click', '.msgedit', function(e){
    //     e.preventDefault();
    //     var uuid = $(this).parents('tr').data('id');
    //     $.get( url+"/api/template/"+uuid, function( data ) {
    //         data = data.data
    //         var selected = data.feature;
    //         $("#feature").filter(function() {
    //         return $(this).text() == selected;
    //         }).prop('selected', true);
    //         $("#email-title").val(data.title);
    //         $('#email_editor').summernote('code', data.content);
    //         if(data.type=='SMS'){
    //             $('#rd-sms').click()
    //         }else{
    //             $('#rd-email').click()
    //         }
    //         $("#btn-save").hide();
    //         $("#btn-update").show();
    //         $("#messageModal").modal('show');
    //   });
    // })
    $(document).on('click', '.msgdelete', function(e){
        e.preventDefault();
        var row = $(this).parents('tr')
        var uuid = row.data('id');
         Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            type: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#E97D1F',
            cancelButtonColor: '#7987a1',
            confirmButtonText: 'Yes, delete it!'
        }).then((result) => {
            if (result.value) {
                deleteMessageTemplate(uuid, row)
            }
        });
      });
    $('#btnSendTestEmail').click(function(){
        sendTestEmail();
    });
    });
function sendTestEmail()
{
     $.ajax({
            url: url+"/api/message/send",
            type: 'POST',
            data:{
                feature:'CUSTOMER_REGISTRATION',
                subject:'Test Registration Email',
                id:'1',
                recipient:'john.doe-af83d6@inbox.mailtrap.io',
                mail_data: {'firstname':'Adam', 'lastname':'John', 'url':'<a href="https://google.com">Here</a>'}
            },
            success: function(result) {
                console.log(result)
            }
        });
}
function deleteMessageTemplate(uuid, row)
{
     $.ajax({
            url: url+"/api/template/delete/"+uuid,
            type: 'DELETE',
            success: function(result) {
                console.log(result)
                $('#template-list').remove(row);
            }
        });
}
function updateMessageTemplate(endpoint){
    var title = $('#email-title').val();
        var content = $('#email_editor').val();
        var feature = $('#feature').val();
        var type = checked_value;
        var jqxhr = $.post(url+"/api/template/"+endpoint,
            {
                title: title,
                content: content,
                feature: feature,
                message_type: type,
            },
            function(data, status){
                console.log(data)
                displayMessage(data.message, 'success');
            })
            .fail(function(data, status) {
                displayMessage(data.responseJSON.message, 'error');
            })
}
    //var txtarea = document.getElementById(areaId);
function insertTextArea(areaId,text) {
    var txtarea = document.getElementById(areaId);
    var scrollPos = txtarea.scrollTop;
    var strPos = 0;
    var br = ((txtarea.selectionStart || txtarea.selectionStart == '0') ?
        "ff" : (document.selection ? "ie" : false ) );
    if (br == "ie") {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        strPos = range.text.length;
    }
    else if (br == "ff") strPos = txtarea.selectionStart;
    var front = (txtarea.value).substring(0,strPos);
    var back = (txtarea.value).substring(strPos,txtarea.value.length);
    txtarea.value=front+text+back;
    strPos = strPos + text.length;
    if (br == "ie") {
        txtarea.focus();
        var range = document.selection.createRange();
        range.moveStart ('character', -txtarea.value.length);
        range.moveStart ('character', strPos);
        range.moveEnd ('character', 0);
        range.select();
    }
    else if (br == "ff") {
        txtarea.selectionStart = strPos;
        txtarea.selectionEnd = strPos;
        txtarea.focus();
    }
    txtarea.scrollTop = scrollPos;
}
    </script>

<div class="content-body">
  <div class="container pd-x-0">
    <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
      <div style="float:left;">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb breadcrumb-style1 mg-b-10">
          <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </nav>
        <h4 class="mg-b-0 tx-spacing--1">Notification Template List</h4>
      </div>
      <div style=""> <a href="templates/new" class="btn btn-sm btn-primary" id="btnNewTemplate" ><i data-feather="plus"></i> New Template</a>
</div>
    </div>

      <div class="row row-xs">
            <div class="col-lg-12 col-xl-12 mg-t-10">
                <div class="card mg-b-10">
                    <div class="card-header pd-t-20 d-sm-flex align-items-start justify-content-between bd-b-0 pd-b-0">
                    </div><!-- card-header -->

                    <div class="table-responsive">

                        <table class="table table-hover mg-b-0" id="basicExample">
                            <thead class="thead-primary">
                                <tr>
                                    <th class="text-center">#</th>
                                    <th>Title</th>
                                    <th>Features</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody id="template-list">

                            @foreach($templates as $template)
                            <tr>
                                <td class="tx-color-03 tx-center">{{ $loop->iteration }}</td>
                                <td class="tx-medium">{{ucfirst($template->title) }}</td>
                                <td class="tx-medium">{{ $template->feature}}</td>
                                <td class=" text-center">
                                    <div class="dropdown-file">
                                        <a href="" class="dropdown-link" data-toggle="dropdown"><i data-feather="more-vertical"></i></a>
                                        <div class="dropdown-menu dropdown-menu-right">
                                        
                                        <a href="templates/new/?templateid={{$template->uuid}}" class="dropdown-item details text-primary"><i class="fas fa-edit"></i> Edit</a>
                        
                                        <a href="templates/new/?templateid={{$template->uuid}}" class="dropdown-item details text-danger"><i class="fas fa-trash"></i> Delete</a>
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

   {{-- <div class="modal fade" id="messageModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Message Template</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div>
                <form id="frmMessaging">
                    <div class="form-group">
                        <input name="msg-type" type="radio" id="rd-email" value="email" checked />  Email
                        <input name="msg-type" type="radio" id="rd-sms" value="SMS" />  SMS
                    </div>
                    <div class="form-group">
                        <select class="form-control" id="feature" aria-placeholder="Feature"></select>
                    </div>
                    <div class="form-group">
                        <input type="text" class="form-control" id="email-title" placeholder="Title">
                    </div>
                    <div class="form-group">
                        <label for="message-text" class="col-form-label">Message:</label>
                        <textarea class="form-control" id="email_editor"></textarea>
                    </div>
                </form>
            </div>
            <div>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="firstname">Firstname</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="lastname">Lastname</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="address">Address</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="email">Email</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="password">Password</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="url">URL</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_name">Customer Name</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_email">Customer Email</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_phone">Customer Phone</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_address">Customer Address</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="customer_whatsapp">Whatsapp</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="preferred_communication">Communication</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="booking_fee">Booking Fee</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="diagnosis_fee">Diagnosis Fee</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="service">Service</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="job_ref">Job Ref</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="invoice">Invoice</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="date">Date</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="time">Time</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="passport">Passport</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="technician_id">Technician ID</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="technician_name">Technician Name</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="completed_jobs">Completed Jobs</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="technician_rating">Technician Rating</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="cse_name">CSE Name</button>
                <button type="button" class="btn btn-xs btn-placeholder btn-secondary" data-val="discount">Discount</button>








            </div>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary" id="btn-save">Save message</button>
            <button type="button" class="btn btn-primary" id="btn-update">Update message</button>

        </div>
        </div>
    </div>
   </div> --}}
</div>

@endsection