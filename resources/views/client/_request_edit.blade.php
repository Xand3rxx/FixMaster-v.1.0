@extends('layouts.client')
@section('title', 'Service Details')
@section('content')
@include('layouts.partials._messages')
<link rel="stylesheet" href="{{ asset('assets/dashboard/assets/css/lightgallery.css') }}" />

<div class="col-lg-8 col-12" style="margin-top: 3rem;">


    <div class="row">
        <h5 class="ml-3">Editing {{ $userServiceRequest->unique_id }} Service request details</h5>

        <form class="p-4" method="POST" action="{{ route('client.update_request', [ 'request'=>$userServiceRequest->uuid, 'locale'=>app()->getLocale() ])}}" enctype="multipart/form-data">
            @csrf 
            <input type="hidden" value="{{ $userServiceRequest->id ?? '' }}" name="servicereq" >
            <!-- ROW 1 -->
            <div class="col-md-12">
                <div class="form-group position-relative">
                    <label>Scheduled Date & Time :<span class="text-danger">*</span></label>
                    <i data-feather="calendar" class="fea icon-sm icons"></i>
                    <input name="timestamp" type="text" class="form-control pl-5 @error('timestamp') is-invalid @enderror" placeholder="Click to select :" id="service-date-time" readonly value="{{ old('timestamp') ?? \Carbon\Carbon::parse($userServiceRequest->preferred_time, 'UTC')->isoFormat('YYYY/MM/DD') }}">
                    @error('timestamp')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div><!--end col-->

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

            <div class="row col-md-12 mb-4">
                <div class="col-md-9">
                    <div class="attachments">
                        <div class="form-group position-relative custom-file">
                            <label>Upload More Media Files (Optional) :</label>
                            <input type="file" name="media_file[]" class="form-control-file btn btn-primary btn-sm" onchange="ValidateSize(this);" id="custom_file_1" accept="image/*,.txt,.doc,.docx,.pdf" />
                            <small class="text-muted" style="font-size: 10px;" >File must not be more than 2MB</small>
                        </div> 
                    </div> 
                </div><!--end col-->
        
                <div class="form-group position-relative" style="margin-top: 1.91rem !important;">
                    <a class="btn btn-primary btn-sm" id="add-more-file" style="font-size: 14px; font-weight: bold;">+</a>
                </div> 
            </div><!--end col-->

            <div class="col-md-12">
                <button type="submit" class="btn btn-primary btn-block">Update Request</button>
            </div><!--end col-->

        </form><!--end form-->
        <hr>
        <div class="col-md-12">
            <h5>Previosuly Uploaded Media Files</h5>
            @if (count($userServiceRequest['serviceRequestMedias']) > 0)
                <div class="row row-xs">
                    @foreach ($userServiceRequest['serviceRequestMedias'] as $item)
                        @include('client._media_file')
                    @endforeach
                </div>
            @else
                <h6 class="mt-4">Files have not been uploaded for this request.</h6>
            @endif
        </div>

    </div><!--end row-->

</div>


@push('scripts')
    <script src="{{ asset('assets/client/js/requests/4c676ab8-78c9-4a00-8466-a10220785892.js') }}"></script> 
    <script src="{{ asset('assets/dashboard/assets/js/lightgallery-all.min.js') }}"></script>

    <script>
    $(function(){
        //Initiate light gallery plugin
        $('.lightgallery').lightGallery();
    });
    
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

    let count = 1;
    
    $('body').on('click', '#add-more-file', function () {
        count++;
        $('.attachments').append('<div class="form-group position-relative custom-file mt-3 remove-file">'+
            '<input type="file" name="media_file[]" accept="image/*,.txt,.doc,.docx,.pdf" class="form-control-file btn btn-primary btn-sm" onchange="ValidateSize(this);" id="custom_file_'+count+'"  />'+
            '<small style="font-size: 10px;" class="text-muted">File must not be more than 2MB</small>'+
        '<div class="form-group position-relative"><a class="btn btn-danger btn-sm remove-media-file" style="font-size: 14px; font-weight: bold;">-</a></div></div>');
    });

    //Remove sub service row
    $(document).on('click', '.remove-media-file', function() {
        count--;
        $(this).closest(".remove-file").remove();
    });
</script>

    
@endpush

@endsection