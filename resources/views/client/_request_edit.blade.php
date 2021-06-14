@extends('layouts.client')
@section('title', 'Service Details')
@section('content')
@include('layouts.partials._messages')

{{-- {{ dd($service->serviceRequests()->count()) }} --}}
<div class="col-lg-8 col-12" style="margin-top: 3rem;">
<form class="p-4" method="POST" action="{{ route('client.update_request', [ 'request'=>$userServiceRequest->uuid, 'locale'=>app()->getLocale() ])}}" enctype="multipart/form-data">
    @csrf 

    <div class="row">
    <h5 class="ml-3">Editing {{ $userServiceRequest->unique_id }} Service request details</h5>
    <input type="hidden" value="{{ $userServiceRequest->id ?? '' }}" name="servicereq" >
        <!-- ROW 1 -->
        <div class="col-md-12">
            <div class="form-group position-relative">
                <label>Scheduled Date & Time :<span class="text-danger">*</span></label>
                <i data-feather="calendar" class="fea icon-sm icons"></i>
                <input name="timestamp" type="text" class="form-control pl-5 @error('timestamp') is-invalid @enderror" placeholder="Click to select :" id="service-date-time" readonly value="{{ old('timestamp') ?? \Carbon\Carbon::parse($userServiceRequest->preferred_time, 'UTC')->isoFormat('YYYY/MM/DD HH:mm') }}">
                @error('timestamp')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div><!--end col-->

        <!-- <div class="col-md-6">
            <div class="form-group position-relative">
                <label>Your Phone no. :<span class="text-danger">*</span></label>
                <i data-feather="phone" class="fea icon-sm icons"></i>
                <input name="phone_number" id="phone_number" type="tel" class="form-control pl-5 @error('phone_number') is-invalid @enderror" placeholder="Your Phone No. :" maxlength="11" value="{{ old('phone_number') ?? $userServiceRequest->address->phone_number }}" autocomplete="off">
                @error('phone_number')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div> 
        </div> -->
        <!--end col-->
        
        <!-- <div class="col-md-12">
            <div class="form-group position-relative">
                <label>Address</label>
                <i data-feather="map-pin" class="fea icon-sm icons"></i>
                <textarea name="address" id="address" rows="3" class="form-control pl-5 @error('address') is-invalid @enderror" placeholder="Address of where the service is required">{{ old('address') ?? $userServiceRequest->address->address }}</textarea>
                @error('address')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div> -->
        <!--end col--> 

        <div class="col-md-12">
            <div class="form-group position-relative">
                <label>Tell us more about the service you need :</label>
                <i data-feather="message-circle" class="fea icon-sm icons"></i>
                <textarea name="description" id="description" rows="3" class="form-control pl-5 @error('description') is-invalid @enderror" placeholder="If there is an equipment involved, do tell us about the equipment e.g. the make, model, age of the equipment etc. ">{{ old('description') ?? $userServiceRequest->description }}</textarea>
                @error('description')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $message }}</strong>
                    </span>
                @enderror
            </div>
        </div><!--end col--> 



        <div class="col-md-3 card-body">
            <div class="form-group position-relative">
                <a class="btn btn-outline btn-dark btn-pill btn-outline-1x btn-sm" id="add-more-file">Add more attachments</a>
            </div> 
        </div><!--end col-->

          <div class="col-md-9 form-group card-body pl-0">
          <div class="attachments">
            <div class="form-group position-relative custom-file">
                <input type="file" name="media_file[]" class="form-control-file btn btn-primary btn-sm" onchange="ValidateSize(this);" id="custom_file_1" accept="image/*,.txt,.doc,.docx,.pdf" />
                <small style="font-size: 10px;" class="text-muted">File must not be more than 2MB</small>
            </div> 
            </div> 
          </div>

    </div><!--end row-->

    <div class="row">
        <div class="col-sm-12">
        <button type="submit" class="submitBnt btn btn-success btn-lg btn-block">Update</button>
        </div><!--end col-->
    </div><!--end row-->




             
        <div class="row">
        @foreach($images as $image) 
            @php
                $attached_files = json_decode($image['media_files']['unique_name'], true);                
            @endphp
    @if($attached_files)
            @foreach($attached_files as $attached_file) 
            <div class="col-lg-2 col-md-3 col-6 mt-4 pt-2">
                <div class="card shop-list border-0 position-relative">

                    <div class="shop-image position-relative overflow-hidden rounded shadow">
                        <img height="10px" src="{{ asset('assets/service-request-media-files/'.$attached_file) }}" class="img-fluid" alt="">
                    </div>
                </div>
            </div><!--end col-->
            @endforeach
    @endif
        @endforeach
    </div>


</form><!--end form-->

</div>


@push('scripts')
<script>
function ValidateSize(file) {
        if (typeof(file.files[0]) === "undefined") {
            $(file).val('');
            $(file).parent('.custom-file').find('label').text('Choose File');
            return false;
        }
        var FileSize = file.files[0].size / 1024 / 1024;
        if (FileSize > 2) {
            alert('File size exceeds 2 MB');
            $(file).val(''); //for clearing with Jquery
        } else {
            $(file).parent('.custom-file').find('label').text(file.files[0].name);
        }
    }
    
 $('body').on('click', '#add-more-file', function () {
        var count = parseInt($('.attachments').find('.custom-file:nth-last-child(1) input').prop('id').split("_")[2]) + 1; 
        // $('.attachments').append('<div class="custom-file">'+
        //     '<label class="custom-file-label" for="custom_file_'+count+'">file here</label>'+
        //     '<input type="file" name="filename[]" accept="application/pdf, image/gif, image/jpeg, image/png" class="custom-file-input" size="20" onchange="ValidateSize(this);" id="custom_file_'+count+'">'+
        //     '</div>')
            $('.attachments').append('<div class="form-group position-relative custom-file">'+
                '<input type="file" name="media_file[]" accept="image/*,.txt,.doc,.docx,.pdf" class="form-control-file btn btn-primary btn-sm" onchange="ValidateSize(this);" id="custom_file_'+count+'"  />'+
                '<small style="font-size: 10px;" class="text-muted">File must not be more than 2MB</small>'+
            '</div>')
    });
</script>
@endpush

@endsection