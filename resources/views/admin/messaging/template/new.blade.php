@extends('layouts.dashboard')
@section('title', 'New Message')
@section('content')
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/jlistbox/css/jquery.transfer.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/dashboard/assets/jlistbox/icon_font/css/icon_font.css') }}">
    <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">

<!-- include summernote css/js -->
<style>
 .btn-placeholder{
   margin-bottom:5px;
 }
 .placeholders{
     padding:10px;
 }
.note-editable { background-color: white !important; }
</style>
    <div class="content-body">
        <div class="container pd-x-0">
            <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                <div>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb breadcrumb-style1 mg-b-10">
                            <li class="breadcrumb-item"><a href="{{ route('admin.index', app()->getLocale()) }}">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.message_template', app()->getLocale()) }}">Message Templates</a></li>
                            <li class="breadcrumb-item active" aria-current="page">New Email</li>
                        </ol>
                    </nav>
                </div>
            </div>

            @csrf
            <fieldset class="form-group border p-4">
                <legend class="w-auto px-2">Message Template</legend>
                <div class="form-row">
                            <div class="form-group col-md-12">
                                <div class="message-div">
                                <div class="form-group">
                                <label for="feature" class="col-form-label">Feature:</label>
                                    <select class="form-control" id="feature" aria-placeholder="Feature"></select>
                                </div>
                                <div class="form-group">
                                <label for="feature" class="col-form-label">Title:</label>
                                    <input type="text" class="form-control" id="email-title" placeholder="Title">
                                </div>
                                <label for="message-text" class="col-form-label">Email:</label>
                                    <textarea class="form-control" id="email_editor"></textarea>
                                 <div class="placeholders">
                                 <label for="message-text" class="col-form-label">SMS:</label>
                                    <textarea class="form-control hidden" id="sms_editor"></textarea>
                                 <div class="placeholders">
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

                            </div>
        <button type="button" class="btn btn-primary" id="btn-save">Save message</button>&nbsp;&nbsp;&nbsp;&nbsp;
        <button type="button" class="btn btn-primary" id="btn-update">Update message</button>
                         </div>
            </fieldset>
              

        </div>
    </div>
@endsection

@push('scripts')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<!-- include summernote css/js -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js" defer></script>
<script>
    var url = window.location.origin;
    var editor_disabled = false;
    var checked_value = 'Email';
    $(document).ready(function (){
        $.get( url+"/api/template/features", function( data ) {
            $.each(data, function(key, val){
                $('<option>').val(val).text(val).appendTo('#feature');
            })
        });
        $('#email_editor').summernote({height: 150});
       
        let params = (new URL(document.location)).searchParams;
         if(params.get("templateid")){
             const id = params.get("templateid");
             getTemplate(id);
         }
        $("#btn-save").show();
            $("#btn-update").hide();
            $("#email_editor").summernote({
            height: 150
        });
        $(".note-editable").on('focus', function(){
                editor_disabled = false;
                })
            $("#sms_editor").on('focus', function(){
                editor_disabled = true;
                })
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
                insertTextArea('sms_editor',toInsert)
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
       
        $(document).on('click', '.msgedit', function(e){
            e.preventDefault();
            var uuid = $(this).parents('tr').data('id');
            $.get( url+"/api/template/"+uuid, function( data ) {
                data = data.data
                var selected = data.feature;
                $("#feature").filter(function() {
                return $(this).text() == selected;
                }).prop('selected', true);
                $("#email-title").val(data.title);
                $('#email_editor').summernote('code', data.content);
                if(data.type=='SMS'){
                    $('#rd-sms').click()
                }else{
                    $('#rd-email').click()
                }
                $("#btn-save").hide();
                $("#btn-update").show();
                $("#messageModal").modal('show');
        });
        })
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
                    feature:'CUSTOMER_DIAGNOSIS_INVOICE',
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
    function updateMessageTemplate(endpoint){
        var title = $('#email-title').val();
            var content = $('#email_editor').val();
            var sms = $('#sms_editor').val();
            var feature = $('#feature').val();
            
            var jqxhr = $.post(url+"/api/template/"+endpoint,
                {
                    title: title,
                    content: content,
                    feature: feature,
                    sms: sms,
                },
                function(data, status){
                    console.log(data)
                    displayMessage(data.message, 'success');
                })
                .fail(function(data, status) {
                    displayMessage(data.responseJSON.message, 'error');
                })
    }
    function getTemplate(uuid){
        $.get( url+"/api/template/"+uuid, function( data ) {
            data = data.data
            var selected = data.feature;
            $(`#feature option[value='${selected}']`).prop('selected', true);
            $("#email-title").val(data.title);
            $('#email_editor').summernote('code', data.content);
            $('#sms_editor').val(data.sms);
            if(data.type=='SMS'){
                $('#rd-sms').click()
            }else{
                $('#rd-email').click()
            }
            $("#btn-save").hide();
            $("#btn-update").show();
            $("#messageModal").modal('show');
      });
    }
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
@endpush